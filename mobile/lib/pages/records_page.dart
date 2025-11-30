import 'dart:async';

import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/info_card.dart';
import 'profile_page.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import '../api_config.dart';
import 'package:path_provider/path_provider.dart';
import 'package:open_filex/open_filex.dart';
import 'dart:io';
import 'package:permission_handler/permission_handler.dart';

class RecordsPage extends StatefulWidget {
  final bool initialDarkMode;
  final ValueChanged<bool>? onDarkModeChanged;
  
  const RecordsPage({
    super.key, 
    this.initialDarkMode = false,
    this.onDarkModeChanged,
  });

  @override
  State<RecordsPage> createState() => _RecordsPageState();
}

class _RecordsPageState extends State<RecordsPage> {
  final int _selectedIndex = 0;
  late bool _isDarkMode;
  late Future<List<Map<String, dynamic>>> _recordsFuture;

  @override
  void initState() {
    super.initState();
    _isDarkMode = widget.initialDarkMode;
    _recordsFuture = fetchRecords(); // fetch API on init
  }

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    if (index == 1) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => ProfilePage(
          initialDarkMode: _isDarkMode,
          onDarkModeChanged: _onDarkModeChanged,
        )),
      );
    }
  }

  void _onDarkModeChanged(bool newValue) {
    setState(() {
      _isDarkMode = newValue;
    });
    // Notify parent about the dark mode change
    widget.onDarkModeChanged?.call(newValue);
  }

  // ✅ Fetch records directly as JSON maps
  Future<List<Map<String, dynamic>>> fetchRecords() async {
    final url = Uri.parse('${ApiConfig.baseUrl}records');
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('api_token') ?? '';

    final response = await http.get(
      url,
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    final Map<String, dynamic> recordsResponse = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final List data = recordsResponse['records'];
      
      // Format dates in records
      final formatted = List<Map<String, dynamic>>.from(data).map((record) {
        return {
          ...record,
          'date_reported': _formatDate(record['date_reported']),
          'date_recovered': record['date_recovered'] != null ? _formatDate(record['date_recovered']) : null,
        };
      }).toList();
      
      return formatted;
    } else {
      throw Exception('Failed to load records');
    }
  }

  // Helper function to format dates
  String _formatDate(String? dateString) {
    if (dateString == null || dateString.isEmpty) return 'Not provided';
    try {
      final date = DateTime.parse(dateString);
      final months = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
      return '${months[date.month - 1]} ${date.day}, ${date.year}';
    } catch (e) {
      return dateString;
    }
  }

 Future<void> _downloadRecordsPdf() async {
  try {
    // Request permission
    final status = await Permission.storage.request();

    if (!status.isGranted) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text("Storage permission required")),
      );
      return;
    }

    // Get API token
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('api_token') ?? '';

    final url = '${ApiConfig.baseUrl}records/export-pdf';

    // Call backend
    final response = await http.get(
      Uri.parse(url),
      headers: {'Authorization': 'Bearer $token'},
    );

    if (response.statusCode == 200) {
      // Save to Downloads folder (Android)
      final downloadsDir = Directory('/storage/emulated/0/Download');
      final filePath =
          '${downloadsDir.path}/patient-record-${DateTime.now().millisecondsSinceEpoch}.pdf';

      final file = File(filePath);
      await file.writeAsBytes(response.bodyBytes);

      // Open file after saving
      await OpenFilex.open(filePath);

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('PDF saved to Downloads folder')),
        );
      }
    } else {
      throw Exception('Failed to download PDF: ${response.statusCode}');
    }
  } catch (e) {
    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error: $e')),
      );
    }
  }
}


  @override
  Widget build(BuildContext context) {
    final Color backgroundColor = _isDarkMode ? const Color(0xFF111827) : Colors.white;
    final Color textColor = _isDarkMode ? Colors.white : const Color(0xFF296E5B);

    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppHeader(
        title: "Records",
        showProfile: true,
        isDarkMode: _isDarkMode,
        onDarkModeChanged: _onDarkModeChanged,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  "Records",
                  style: TextStyle(
                    color: textColor,
                    fontWeight: FontWeight.bold,
                    fontSize: 20,
                  ),
                ),
                ElevatedButton.icon(
                  onPressed: _downloadRecordsPdf,
                  icon: const Icon(Icons.download),
                  label: const Text('Export'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF296E5B),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            Expanded(
              child: FutureBuilder<List<Map<String, dynamic>>>(
                future: _recordsFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const Center(child: CircularProgressIndicator());
                  } else if (snapshot.hasError) {
                    return Center(
                        child: Text(
                      'Error: ${snapshot.error}',
                      style: TextStyle(color: textColor),
                    ));
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return Center(
                        child: Text(
                      'No records found',
                      style: TextStyle(color: textColor),
                    ));
                  }

                  final records = snapshot.data!;
                  return ListView.separated(
                    itemCount: records.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 12),
                    itemBuilder: (context, index) {
                      final r = records[index];

                      return InfoCard(
                        date: r['date_reported'],
                        diagnosis: r['disease_name'],
                        doctor: r['doctor_name'] ?? '',
                        hospital: r['hospital_name'],
                        status: r['status'],
                        isDarkMode: _isDarkMode,
                        reportedRemarks: r['reported_remarks'] ?? '',
                        recoveredRemarks: r['recovered_remarks'] ?? '',
                      );
                    },
                  );
                },
              ),
            ),
          ],
        ),
      ),
      bottomNavigationBar: Footer(
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        isDarkMode: _isDarkMode,
      ),
    );
  }
}