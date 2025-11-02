import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import '../components/header.dart';
import '../components/footer.dart';
import 'records_page.dart';

class ProfileTheme {
  final Color backgroundColor;
  final Color primaryColor;
  final Color titleTextColor;
  final Color valueTextColor;
  final Color infoTitleColor;
  final Color cardColor;
  final Color borderColor;

  const ProfileTheme({
    required this.backgroundColor,
    required this.primaryColor,
    required this.titleTextColor,
    required this.valueTextColor,
    required this.infoTitleColor,
    required this.cardColor,
    required this.borderColor,
  });

  // Light Theme
  static const light = ProfileTheme(
    backgroundColor: Colors.white,
    primaryColor: Color(0xFF296E5B),
    titleTextColor: Colors.white,
    valueTextColor: Color(0xFF296E5B),
    infoTitleColor: Colors.black87,
    cardColor: Colors.white,
    borderColor: Color(0xFFE5E7EB),
  );

  // Dark Theme - updated with #111827 background
  static const dark = ProfileTheme(
    backgroundColor: Color(0xFF111827),
    primaryColor: Color(0xFF296E5B),
    titleTextColor: Colors.white,
    valueTextColor: Colors.white,
    infoTitleColor: Colors.white70,
    cardColor: Color(0xFF1F2937),
    borderColor: Color(0xFF374151),
  );
}

class ProfilePage extends StatefulWidget {
  final bool initialDarkMode;
  final ValueChanged<bool>? onDarkModeChanged;
  
  const ProfilePage({
    super.key, 
    this.initialDarkMode = false, 
    this.onDarkModeChanged
  });

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  final int _selectedIndex = 1;
  late bool _isDarkMode;

  @override
  void initState() {
    super.initState();
    _isDarkMode = widget.initialDarkMode;
  }

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    if (index == 0) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => RecordsPage(
          initialDarkMode: _isDarkMode,
          onDarkModeChanged: widget.onDarkModeChanged,
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
    final ProfileTheme theme = _isDarkMode ? ProfileTheme.dark : ProfileTheme.light;

    return Scaffold(
      backgroundColor: theme.backgroundColor,
      appBar: AppHeader(
        title: "Profile",
        showProfile: true,
        isDarkMode: _isDarkMode,
        onDarkModeChanged: _onDarkModeChanged,
      ),
      body: SingleChildScrollView(
        child: Column(
          children: [
            Container(
              color: theme.primaryColor,
              width: double.infinity,
              padding: const EdgeInsets.symmetric(vertical: 24),
              child: Column(
                children: [
                  Container(
                    width: 120,
                    height: 120,
                    decoration: const BoxDecoration(
                      shape: BoxShape.circle,
                      color: Colors.white,
                    ),
                    padding: const EdgeInsets.all(8),
                    child: ClipOval(
                      child: SvgPicture.asset(
                        "assets/images/profile-default.svg",
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    "Jennie Ruby Jane Kim",
                    style: TextStyle(
                      color: theme.titleTextColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 18,
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 16),

            // Information rows - now in cards
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              child: Column(
                children: [
                  _InfoCard(
                    title: "Birthdate", 
                    value: "January 16, 1996",
                    theme: theme,
                  ),
                  const SizedBox(height: 12),
                  _InfoCard(
                    title: "Nationality", 
                    value: "Filipino",
                    theme: theme,
                  ),
                  const SizedBox(height: 12),
                  _InfoCard(
                    title: "Email Address", 
                    value: "jenduki@gmail.com",
                    theme: theme,
                  ),
                  const SizedBox(height: 12),
                  _InfoCard(
                    title: "Address",
                    value: "150 Archbishop Reyes Avenue, Banilad, Cebu City,\nCebu 6000, Philippines",
                    theme: theme,
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

class _InfoCard extends StatelessWidget {
  final String title;
  final String value;
  final ProfileTheme theme;

  const _InfoCard({
    required this.title, 
    required this.value,
    required this.theme,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: theme.cardColor,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: theme.borderColor),
      ),
      padding: const EdgeInsets.all(16),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 100,
            child: Text(
              title,
              style: TextStyle(
                fontWeight: FontWeight.w500,
                color: theme.infoTitleColor,
              ),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: TextStyle(
                color: theme.valueTextColor,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }
}