import 'package:flutter/material.dart';
import '../login.dart';

class LogoutDialog extends StatelessWidget {
  final bool isDarkMode;
  
  const LogoutDialog({
    super.key,
    required this.isDarkMode,
  });

  @override
  Widget build(BuildContext context) {
    // Colors for dark mode
    final Color darkBackgroundColor = const Color(0xFF1F2937);
    final Color darkCardColor = const Color(0xFF374151);
    final Color darkTextColor = Colors.white;
    final Color darkSecondaryTextColor = Colors.grey.shade300;
    
    // Colors for light mode
    final Color lightBackgroundColor = Colors.white;
    final Color lightCardColor = Colors.white;
    final Color lightTextColor = Colors.black87;
    final Color lightSecondaryTextColor = Colors.grey.shade600;

    final Color backgroundColor = isDarkMode ? darkBackgroundColor : lightBackgroundColor;
    final Color cardColor = isDarkMode ? darkCardColor : lightCardColor;
    final Color textColor = isDarkMode ? darkTextColor : lightTextColor;
    final Color secondaryTextColor = isDarkMode ? darkSecondaryTextColor : lightSecondaryTextColor;
    final Color primaryColor = const Color(0xFF296E5B);

    return Dialog(
      backgroundColor: Colors.transparent,
      insetPadding: const EdgeInsets.all(24),
      child: Container(
        decoration: BoxDecoration(
          color: cardColor,
          borderRadius: BorderRadius.circular(16),
          boxShadow: [
            BoxShadow(
              // replaced with a const Color.fromRGBO to avoid withOpacity warnings
              color: const Color.fromRGBO(0, 0, 0, 0.2),
              blurRadius: 20,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Title
              Text(
                "Logout",
                style: TextStyle(
                  color: textColor,
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
              
              const SizedBox(height: 16),
              
              Text(
                "Are you sure you want to logout?",
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: secondaryTextColor,
                  fontSize: 16,
                  height: 1.4,
                ),
              ),
              
              const SizedBox(height: 24),
              
              // Buttons
              Row(
                children: [
                  // Cancel Button
                  Expanded(
                    child: Container(
                      height: 48,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(8),
                        border: Border.all(
                          color: isDarkMode ? Colors.grey.shade600 : Colors.grey.shade300,
                        ),
                      ),
                      child: TextButton(
                        onPressed: () {
                          Navigator.of(context).pop();
                        },
                        style: TextButton.styleFrom(
                          foregroundColor: secondaryTextColor,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                        child: Text(
                          "Cancel",
                          style: TextStyle(
                            color: secondaryTextColor,
                            fontWeight: FontWeight.w600,
                            fontSize: 16,
                          ),
                        ),
                      ),
                    ),
                  ),
                  
                  const SizedBox(width: 12),
                  
                  // Logout Button
                  Expanded(
                    child: Container(
                      height: 48,
                      decoration: BoxDecoration(
                        color: primaryColor,
                        borderRadius: BorderRadius.circular(8),
                        boxShadow: [
                          BoxShadow(
                            // replaced with a const Color.fromRGBO matching primaryColor with 0.3 opacity
                            color: const Color.fromRGBO(41, 110, 91, 0.3),
                            blurRadius: 8,
                            offset: const Offset(0, 2),
                          ),
                        ],
                      ),
                      child: TextButton(
                        onPressed: () {
                          Navigator.of(context).pop();
                          _navigateToLogin(context);
                        },
                        style: TextButton.styleFrom(
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                        child: const Text(
                          "Logout",
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.w600,
                            fontSize: 16,
                          ),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _navigateToLogin(BuildContext context) {
    // Navigate to login page and remove all previous routes
    Navigator.pushAndRemoveUntil(
      context,
      MaterialPageRoute(builder: (_) => const LoginPage()),
      (Route<dynamic> route) => false, // Remove all routes
    );
  }

  // Static method to show the dialog
  static void show({
    required BuildContext context,
    required bool isDarkMode,
  }) {
    showDialog(
      context: context,
      // replaced with const Color.fromRGBO to avoid withOpacity warning
      barrierColor: const Color.fromRGBO(0, 0, 0, 0.5),
      builder: (BuildContext context) {
        return LogoutDialog(isDarkMode: isDarkMode);
      },
    );
  }
}