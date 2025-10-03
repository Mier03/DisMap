import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/info_card.dart';
import 'profile_page.dart';
import 'settings_page.dart';

class RecordsPage extends StatefulWidget {
  const RecordsPage({super.key});

  @override
  State<RecordsPage> createState() => _RecordsPageState();
}

class _RecordsPageState extends State<RecordsPage> {
  int _selectedIndex = 0;

  void _onItemTapped(int index) {
    if (index == 0) return; // Already on Records
    if (index == 1) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const SettingsPage()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppHeader(
        title: "Disease Mapper",
        onProfileTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (_) => const ProfilePage()),
          );
        },
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              "Records",
              style: TextStyle(
                color: Color(0xFF296E5B),
                fontWeight: FontWeight.bold,
                fontSize: 20,
              ),
            ),
            const SizedBox(height: 12),
            Expanded(
              child: ListView(
                children: [
                  InfoCard(
                    date: "August 30, 2028",
                    diagnosis: "Dengue",
                    doctor: "Jane Smith, MD",
                    hospital: "Cebu Doctors Hospital",
                    status: "Active",
                  ),
                  InfoCard(
                    date: "August 30, 2028",
                    diagnosis: "Malaria",
                    doctor: "Jane Smith, MD",
                    hospital: "Cebu Doctors Hospital",
                    status: "Recovered",
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
      ),
    );
  }
}
