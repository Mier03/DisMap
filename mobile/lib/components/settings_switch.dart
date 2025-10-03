import 'package:flutter/material.dart';

class SettingsSwitch extends StatefulWidget {
  final String title;
  final bool initialValue;
  final ValueChanged<bool>? onChanged;

  const SettingsSwitch({
    super.key,
    required this.title,
    this.initialValue = false,
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
    return Card(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: Color(0xFF296E5B)),
      ),
      margin: const EdgeInsets.symmetric(vertical: 8),
      child: SwitchListTile(
        contentPadding: const EdgeInsets.symmetric(vertical: 20, horizontal: 16),
          title: Text(
            widget.title,
            style: const TextStyle(
              fontWeight: FontWeight.w500,
            ),
          ),
        value: _value,
        onChanged: (val) {
          setState(() => _value = val);
          widget.onChanged?.call(val);
        },
        activeColor: Colors.white, // thumb color when active
        activeTrackColor: const Color(0xFF296E5B), // background when active
        inactiveThumbColor: const Color(0xFF296E5B), // thumb when inactive
        inactiveTrackColor: Colors.grey.shade300, // background when inactive
      ),
    );
  }
}
