import 'package:flutter/material.dart';
import '../components/header.dart';
import '../components/footer.dart';
import '../components/settings_switch.dart';
import 'records_page.dart';
import 'profile_page.dart';

class SettingsPage extends StatefulWidget {
  final bool initialIsDarkMode;
  const SettingsPage({super.key, this.initialIsDarkMode = false});

  @override
  State<SettingsPage> createState() => _SettingsPageState();
}

class _SettingsPageState extends State<SettingsPage> {
  final int _selectedIndex = 1;
  late bool _isDarkMode;


  @override
  void initState() {
    super.initState();
    _isDarkMode = widget.initialIsDarkMode;
  }

  void _onItemTapped(int index) {
    if (index == 1) return;
    if (index == 0) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => RecordsPage(isDarkMode: _isDarkMode)),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final Color backgroundColor = _isDarkMode ? const Color(0xFF111827) : Colors.white;
    final Color textColor = _isDarkMode ? Colors.white : const Color(0xFF296E5B);
    final Color cardColor = _isDarkMode ? const Color(0xFF111827) : Colors.white;
    final Color borderColor = _isDarkMode ? const Color(0xFF111827) : Colors.grey.shade200;

    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppHeader(
        title: "Disease Mapper",
        onProfileTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (_) => ProfilePage(isDarkMode: _isDarkMode)),
          );
        },
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              "Settings",
              style: TextStyle(
                color: textColor,
                fontWeight: FontWeight.bold,
                fontSize: 20,
              ),
            ),
            const SizedBox(height: 16),
            Container(
              decoration: BoxDecoration(
                color: cardColor,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: borderColor),
              ),
              child: Column(
                children: [
                  SettingsSwitch(
                    title: "Dark Mode",
                    initialValue: _isDarkMode,
                    isDarkMode: _isDarkMode, 
                    onChanged: (val) {
                      setState(() {
                        _isDarkMode = val;
                      });
                    },
                  ),
                  Divider(height: 1, color: borderColor),
                  SettingsSwitch(
                    title: "Notifications",
                    initialValue: false,
                    isDarkMode: _isDarkMode, 
                    onChanged: (val) {
                      // TODO: implement notifications toggle
                    },
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