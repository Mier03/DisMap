import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/settings_switch.dart'; // ✅ import
import 'records_page.dart';
import 'profile_page.dart';

class SettingsPage extends StatefulWidget {
  const SettingsPage({super.key});

  @override
  State<SettingsPage> createState() => _SettingsPageState();
}

class _SettingsPageState extends State<SettingsPage> {
  int _selectedIndex = 1;

  void _onItemTapped(int index) {
    if (index == 1) return; // Already on Settings
    if (index == 0) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const RecordsPage()),
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
              "Settings",
              style: TextStyle(
                color: Color(0xFF296E5B),
                fontWeight: FontWeight.bold,
                fontSize: 20,
              ),
            ),
            const SizedBox(height: 12),
            SettingsSwitch(
              title: "Dark Mode",
              onChanged: (val) {
                // TODO: implement dark mode toggle
              },
            ),
            SettingsSwitch(
              title: "Notifications",
              onChanged: (val) {
                // TODO: implement notifications toggle
              },
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
