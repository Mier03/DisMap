import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import '../components/header.dart';
import '../components/footer.dart';
import 'records_page.dart';
import 'settings_page.dart';


class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  int _selectedIndex = -1; // e.g. 2 for Profile tab

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    if (index == 0) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const RecordsPage()),
      );
    } else if (index == 1) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const SettingsPage()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const AppHeader(
        title: "Disease Mapper",
        showProfile: false, // already on profile page
      ),
      body: SingleChildScrollView(
        child: Column(
          children: [
            // Top section with avatar and name
            Container(
              color: const Color(0xFF296E5B),
              width: double.infinity,
              padding: const EdgeInsets.symmetric(vertical: 24),
              child: Column(
                children: [
                  Container(
                    width: 120, // same as diameter (2x radius 60)
                    height: 120,
                    decoration: const BoxDecoration(
                      shape: BoxShape.circle,
                      color: Colors.white, // optional background
                    ),
                    padding: const EdgeInsets.all(8), // optional padding
                    child: ClipOval(
                      child: SvgPicture.asset(
                        "assets/images/profile-default.svg",
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),
                  const SizedBox(height: 8),
                  const Text(
                    "Jennie Ruby Jane Kim",
                    style: TextStyle(
                      color: Colors.white,
                      fontWeight: FontWeight.bold,
                      fontSize: 18,
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 16),

            // Information rows
            _InfoRow(title: "Birthdate", value: "January 16, 1996"),
            _InfoRow(title: "Nationality", value: "Filipino"),
            _InfoRow(title: "Email Address", value: "jenduki@gmail.com"),
            _InfoRow(
              title: "Address",
              value:
                  "150 Archbishop Reyes Avenue, Banilad, Cebu City,\nCebu 6000, Philippines",
            ),
          ],
        ),
      ),

      // ✅ Add footer here
      bottomNavigationBar: Footer(
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
      ),
    );
  }
}


class _InfoRow extends StatelessWidget {
  final String title;
  final String value;

  const _InfoRow({required this.title, required this.value});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 100,
            child: Text(
              title,
              style: const TextStyle(fontWeight: FontWeight.w500),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(
                color: Color(0xFF296E5B),
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
