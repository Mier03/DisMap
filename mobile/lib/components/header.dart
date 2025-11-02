import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'logout.dart'; 

class AppHeader extends StatelessWidget implements PreferredSizeWidget {
  final String title;
  final bool showProfile;
  final bool isDarkMode;
  final ValueChanged<bool>? onDarkModeChanged;

  const AppHeader({
    super.key,
    required this.title,
    this.showProfile = true,
    this.isDarkMode = false,
    this.onDarkModeChanged,
  });

  void _handleLogout(BuildContext context) {
    LogoutDialog.show(
      context: context,
      isDarkMode: isDarkMode,
    );
  }

  @override
  Widget build(BuildContext context) {
    return AppBar(
      backgroundColor: const Color(0xFF296E5B),
      elevation: 0,
      automaticallyImplyLeading: false,
      title: Row(
        children: [
          SvgPicture.asset(
            'assets/images/logo-w.svg',
            height: 28,
          ),
          const SizedBox(width: 8),
          Text(
            title,
            style: const TextStyle(
              color: Colors.white,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
      actions: [
        // Dark mode toggle
        if (onDarkModeChanged != null) ...[
          IconButton(
            icon: Icon(
              isDarkMode ? Icons.dark_mode : Icons.light_mode,
              color: Colors.white,
            ),
            onPressed: () {
              onDarkModeChanged!(!isDarkMode);
            },
          ),
        ],
        // Profile icon (now functions as logout)
        if (showProfile) ...[
          IconButton(
            icon: const Icon(Icons.account_circle, color: Colors.white),
            onPressed: () {
              _handleLogout(context);
            },
          ),
        ],
      ],
    );
  }

  @override
  Size get preferredSize => const Size.fromHeight(kToolbarHeight);
}