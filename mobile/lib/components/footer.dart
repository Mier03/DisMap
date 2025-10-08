import 'package:flutter/material.dart';

class Footer extends StatelessWidget {
  final int? currentIndex;
  final Function(int) onTap;
  final bool isDarkMode;

  const Footer({
    super.key,
    required this.currentIndex,
    required this.onTap,
    this.isDarkMode = false,
  });

  @override
  Widget build(BuildContext context) {
    // Colors for dark mode
    final Color darkBackgroundColor = const Color(0xFF111827);
    final Color darkSelectedColor = Colors.white;
    final Color darkUnselectedColor = Colors.grey.shade400;
    
    // Colors for light mode
    final Color lightBackgroundColor = Colors.white;
    final Color lightSelectedColor = const Color(0xFF296E5B);
    final Color lightUnselectedColor = Colors.grey;

    return BottomNavigationBar(
      currentIndex: (currentIndex != null && currentIndex! >= 0)
          ? currentIndex!
          : 0,
      onTap: onTap,
      backgroundColor: isDarkMode ? darkBackgroundColor : lightBackgroundColor,
      selectedItemColor: isDarkMode ? darkSelectedColor : lightSelectedColor,
      unselectedItemColor: isDarkMode ? darkUnselectedColor : lightUnselectedColor,
      showUnselectedLabels: true,
      items: const [
        BottomNavigationBarItem(
          icon: Icon(Icons.list),
          label: "Records",
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.settings),
          label: "Settings",
        ),
      ],
    );
  }
}