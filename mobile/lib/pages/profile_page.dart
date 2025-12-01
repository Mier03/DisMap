import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import '../components/header.dart';
import '../components/footer.dart';
import '../api_config.dart';
import 'records_page.dart';
import 'package:image_picker/image_picker.dart';

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
  late Future<Map<String, dynamic>> _userProfileFuture;

  @override
  void initState() {
    super.initState();
    _isDarkMode = widget.initialDarkMode;
    _userProfileFuture = fetchUserProfile();
  }

  // ✅ Fetch user profile as JSON map
  Future<Map<String, dynamic>> fetchUserProfile() async {
    final url = Uri.parse('${ApiConfig.baseUrl}user/profile/upload');
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('api_token') ?? '';

    final response = await http.get(
      url,
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    final Map<String, dynamic> profileResponse = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return profileResponse;
    } else {
      throw Exception('Failed to load user profile');
    }
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

Future<void> _uploadProfileImage(XFile image) async {
  final prefs = await SharedPreferences.getInstance();
  final token = prefs.getString('api_token') ?? '';
  final url = Uri.parse('${ApiConfig.baseUrl}user/profile/upload'); // backend endpoint

  var request = http.MultipartRequest('POST', url);
  request.headers['Authorization'] = 'Bearer $token';
  request.files.add(await http.MultipartFile.fromPath('profile_image', image.path));

  final response = await request.send();

  if (response.statusCode == 200) {
    setState(() {
      _userProfileFuture = fetchUserProfile(); // refresh profile image
    });
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(content: Text('Profile image updated successfully')),
    );
  } else {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(content: Text('Failed to upload profile image')),
    );
  }
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
        child: FutureBuilder<Map<String, dynamic>>(
          future: _userProfileFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(
                child: Text(
                  'Error: ${snapshot.error}',
                  style: TextStyle(color: theme.valueTextColor),
                ),
              );
            } else if (!snapshot.hasData) {
              return Center(
                child: Text(
                  'No profile data available',
                  style: TextStyle(color: theme.valueTextColor),
                ),
              );
            }

            final userProfile = snapshot.data!;
            final userName = userProfile['name'] ?? 'Unknown';
            final rawBirthdate = userProfile['birthdate'] ?? 'Not provided';
            final userEmail = userProfile['email'] ?? 'Not provided';
            final userEthnicity = userProfile['ethnicity'] ?? 'Not provided';
            final userAddress = userProfile['street_address'] ?? 'Not provided';
            final userContactNumber = userProfile['contact_number'] ?? 'Not provided';

            // Format birthdate to Month Day, Year
            String formattedBirthdate = 'Not provided';
            try {
              if (rawBirthdate != 'Not provided') {
                final date = DateTime.parse(rawBirthdate);
                final months = ['January', 'February', 'March', 'April', 'May', 'June',
                  'July', 'August', 'September', 'October', 'November', 'December'];
                formattedBirthdate = '${months[date.month - 1]} ${date.day}, ${date.year}';
              }
            } catch (e) {
              formattedBirthdate = rawBirthdate;
            }

            return Column(
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
                        child: GestureDetector(
                          onTap: () async {
                            final picker = ImagePicker();
                            final XFile? pickedImage =
                                await picker.pickImage(source: ImageSource.gallery);

                            if (pickedImage != null) {
                              await _uploadProfileImage(pickedImage);
                            }
                          },
                          child: ClipOval(
                            child: userProfile['profile_image'] != null &&
                                    userProfile['profile_image'] != ''
                                ? Image.network(
                                    userProfile['profile_image'],
                                    fit: BoxFit.cover,
                                    errorBuilder: (context, error, stackTrace) {
                                      return SvgPicture.asset(
                                        "assets/images/profile-default.svg",
                                        fit: BoxFit.cover,
                                      );
                                    },
                                  )
                                : SvgPicture.asset(
                                    "assets/images/profile-default.svg",
                                    fit: BoxFit.cover,
                                  ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        userName,
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
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: Column(
                    children: [
                      _InfoCard(
                        title: "Birthdate", 
                        value: formattedBirthdate,
                        theme: theme,
                      ),
                      const SizedBox(height: 12),
                      _InfoCard(
                        title: "Nationality", 
                        value: userEthnicity,
                        theme: theme,
                      ),
                      const SizedBox(height: 12),
                      _InfoCard(
                        title: "Email Address", 
                        value: userEmail,
                        theme: theme,
                      ),
                      const SizedBox(height: 12),
                      _InfoCard(
                        title: "Contact Number",
                        value: userContactNumber,
                        theme: theme,
                      ),
                      const SizedBox(height: 12),
                      _InfoCard(
                        title: "Address",
                        value: userAddress,
                        theme: theme,
                      ),
                    ],
                  ),
                ),
              ],
            );
          },
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