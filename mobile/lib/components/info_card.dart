import 'package:flutter/material.dart';

class InfoCard extends StatelessWidget {
  final String date;
  final String diagnosis;
  final String doctor;
  final String hospital;
  final String status;
  final bool isDarkMode;

  const InfoCard({
    super.key,
    required this.date,
    required this.diagnosis,
    required this.doctor,
    required this.hospital,
    required this.status,
    this.isDarkMode = false,
  });

  @override
  Widget build(BuildContext context) {
    // Colors for dark mode
    final Color darkCardColor = const Color(0xFF1F2937);
    final Color darkBorderColor = const Color(0xFF374151);
    final Color darkTextColor = Colors.white;
    final Color darkSecondaryTextColor = Colors.grey.shade300;
    
    // Colors for light mode
    final Color lightCardColor = Colors.white;
    final Color lightBorderColor = const Color(0xFF296E5B);
    final Color lightTextColor = Colors.black87;
    final Color lightSecondaryTextColor = Colors.grey.shade600;

    final Color cardColor = isDarkMode ? darkCardColor : lightCardColor;
    final Color borderColor = isDarkMode ? darkBorderColor : lightBorderColor;
    final Color textColor = isDarkMode ? darkTextColor : lightTextColor;
    final Color secondaryTextColor = isDarkMode ? darkSecondaryTextColor : lightSecondaryTextColor;

    return Card(
      color: cardColor,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: BorderSide(color: borderColor),
      ),
      margin: const EdgeInsets.only(bottom: 12),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  date,
                  style: TextStyle(
                    color: secondaryTextColor,
                    fontSize: 14,
                  ),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                  decoration: BoxDecoration(
                    color: status == "Active" 
                        ? const Color(0xFFDC2626) 
                        : const Color(0xFF16A34A),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    status,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 12,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 8),
            Text(
              diagnosis,
              style: TextStyle(
                color: textColor,
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 8),
            _InfoRow(
              label: "Doctor",
              value: doctor,
              textColor: textColor,
              secondaryTextColor: secondaryTextColor,
            ),
            _InfoRow(
              label: "Hospital",
              value: hospital,
              textColor: textColor,
              secondaryTextColor: secondaryTextColor,
            ),
          ],
        ),
      ),
    );
  }
}

class _InfoRow extends StatelessWidget {
  final String label;
  final String value;
  final Color textColor;
  final Color secondaryTextColor;

  const _InfoRow({
    required this.label,
    required this.value,
    required this.textColor,
    required this.secondaryTextColor,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 80,
            child: Text(
              "$label:",
              style: TextStyle(
                color: secondaryTextColor,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: TextStyle(
                color: textColor,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}