import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/info_card.dart';
import 'profile_page.dart';

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

  @override
  void initState() {
    super.initState();
    _isDarkMode = widget.initialDarkMode;
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
              child: ListView(
                children: [
                  InfoCard(
                    date: "August 30, 2028",
                    diagnosis: "Dengue",
                    doctor: "Jane Smith, MD",
                    hospital: "Cebu Doctors Hospital",
                    status: "Active",
                    isDarkMode: _isDarkMode, 
                  ),
                  const SizedBox(height: 12),
                  InfoCard(
                    date: "August 30, 2028",
                    diagnosis: "Malaria",
                    doctor: "Jane Smith, MD",
                    hospital: "Cebu Doctors Hospital",
                    status: "Recovered",
                    isDarkMode: _isDarkMode, 
                  ),
                ],
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