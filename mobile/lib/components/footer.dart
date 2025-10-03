import 'package:flutter/material.dart';

class Footer extends StatelessWidget {
  final int? currentIndex;
  final Function(int) onTap;

  const Footer({
    super.key,
    required this.currentIndex,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return BottomNavigationBar(
      currentIndex: (currentIndex != null && currentIndex! >= 0)
          ? currentIndex!
          : 0, // Flutter needs a valid index, give it 0
      onTap: onTap,
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
            // This hides the highlight when currentIndex is invalid
      selectedItemColor: (currentIndex == null || currentIndex! < 0)
          ? Colors.grey // fallback color
          : Theme.of(context).primaryColor,
      unselectedItemColor: Colors.grey,
    );
  }
}
