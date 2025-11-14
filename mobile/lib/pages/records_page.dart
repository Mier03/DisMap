import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/info_card.dart';
import 'profile_page.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import '../api_config.dart';

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
      return List<Map<String, dynamic>>.from(data);
    } else {
      throw Exception('Failed to load records');
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
            Text(
              "Records",
              style: TextStyle(
                color: textColor,
                fontWeight: FontWeight.bold,
                fontSize: 20,
              ),
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