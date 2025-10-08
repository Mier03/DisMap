import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/info_card.dart';
import 'profile_page.dart';
import 'settings_page.dart';

class RecordsPage extends StatefulWidget {
  final bool isDarkMode;
  const RecordsPage({super.key, this.isDarkMode = false});

  @override
  State<RecordsPage> createState() => _RecordsPageState();
}

class _RecordsPageState extends State<RecordsPage> {
  final int _selectedIndex = 0;

  void _onItemTapped(int index) {
    if (index == 0) return;

    if (index == 1) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => SettingsPage(initialIsDarkMode: widget.isDarkMode)),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final Color backgroundColor = widget.isDarkMode ? const Color(0xFF111827) : Colors.white;
    final Color textColor = widget.isDarkMode ? Colors.white : const Color(0xFF296E5B);

    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppHeader(
        title: "Disease Mapper",
        onProfileTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (_) => ProfilePage(isDarkMode: widget.isDarkMode)),
          );
        },
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
                    isDarkMode: widget.isDarkMode, 
                  ),
                  const SizedBox(height: 12),
                  InfoCard(
                    date: "August 30, 2028",
                    diagnosis: "Malaria",
                    doctor: "Jane Smith, MD",
                    hospital: "Cebu Doctors Hospital",
                    status: "Recovered",
                    isDarkMode: widget.isDarkMode, 
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
        isDarkMode: widget.isDarkMode,
      ),
    );
  }
}