import 'package:flutter/material.dart';

class SettingsSwitch extends StatefulWidget {
  final String title;
  final bool initialValue;
  final bool isDarkMode;
  final ValueChanged<bool>? onChanged;

  const SettingsSwitch({
    super.key,
    required this.title,
    this.initialValue = false,
    this.isDarkMode = false,
    this.onChanged,
  });

  @override
  State<SettingsSwitch> createState() => _SettingsSwitchState();
}

class _SettingsSwitchState extends State<SettingsSwitch> {
  late bool _value;

  @override
  void initState() {
    super.initState();
    _value = widget.initialValue;
  }

  @override
  Widget build(BuildContext context) {
    // Colors for dark mode
    final Color darkCardColor = const Color(0xFF1F2937);
    final Color darkBorderColor = const Color(0xFF374151);
    final Color darkTextColor = Colors.white;
    
    // Colors for light mode
    final Color lightCardColor = Colors.white;
    final Color lightBorderColor = const Color(0xFF296E5B);
    final Color lightTextColor = Colors.black87;

    return Card(
      color: widget.isDarkMode ? darkCardColor : lightCardColor,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: BorderSide(
          color: widget.isDarkMode ? darkBorderColor : lightBorderColor,
        ),
      ),
      margin: const EdgeInsets.symmetric(vertical: 8),
      child: SwitchListTile(
        contentPadding: const EdgeInsets.symmetric(vertical: 20, horizontal: 16),
        title: Text(
          widget.title,
          style: TextStyle(
            fontWeight: FontWeight.w500,
            color: widget.isDarkMode ? darkTextColor : lightTextColor,
          ),
        ),
        value: _value,
        onChanged: (val) {
          setState(() => _value = val);
          widget.onChanged?.call(val);
        },
        activeThumbColor: Colors.white,
        activeTrackColor: const Color(0xFF296E5B),
        inactiveThumbColor: widget.isDarkMode ? Colors.grey.shade400 : const Color(0xFF296E5B),
        inactiveTrackColor: widget.isDarkMode ? Colors.grey.shade600 : Colors.grey.shade300,
      ),
    );
  }
}