import 'package:flutter/material.dart';

class InfoCard extends StatefulWidget {
  final String date;
  final String diagnosis;
  final String doctor;
  final String hospital;
  final String status;
  final bool isDarkMode;
  final String reportedRemarks;
  final String recoveredRemarks;

  const InfoCard({
    super.key,
    required this.date,
    required this.diagnosis,
    required this.doctor,
    required this.hospital,
    required this.status,
    required this.reportedRemarks,
    required this.recoveredRemarks,
    this.isDarkMode = false,
  });

  @override
  State<InfoCard> createState() => _InfoCardState();
}

class _InfoCardState extends State<InfoCard> {
  bool isExpanded = false;

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

    final Color cardColor = widget.isDarkMode ? darkCardColor : lightCardColor;
    final Color borderColor = widget.isDarkMode ? darkBorderColor : lightBorderColor;
    final Color textColor = widget.isDarkMode ? darkTextColor : lightTextColor;
    final Color secondaryTextColor = widget.isDarkMode ? darkSecondaryTextColor : lightSecondaryTextColor;

    // Get correct remarks based on status
    final String remarks = widget.status == "Active"
        ? widget.reportedRemarks
        : widget.recoveredRemarks;

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
            // Header row
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  widget.date,
                  style: TextStyle(
                    color: secondaryTextColor,
                    fontSize: 14,
                  ),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                  decoration: BoxDecoration(
                    color: widget.status == "Active"
                        ? const Color(0xFFDC2626)
                        : const Color(0xFF16A34A),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    widget.status,
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
              widget.diagnosis,
              style: TextStyle(
                color: textColor,
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),

            const SizedBox(height: 8),

            _InfoRow(label: "Doctor", value: widget.doctor, textColor: textColor, secondaryTextColor: secondaryTextColor),
            _InfoRow(label: "Hospital", value: widget.hospital, textColor: textColor, secondaryTextColor: secondaryTextColor),

            // Expandable remarks
            if (isExpanded) ...[
              const SizedBox(height: 12),
              Text(
                "Remarks:",
                style: TextStyle(
                  color: secondaryTextColor,
                  fontSize: 14,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                remarks.isNotEmpty ? remarks : "No remarks available.",
                style: TextStyle(
                  color: textColor,
                  fontSize: 14,
                ),
              ),
            ],

            // "See more" button
            Align(
              alignment: Alignment.centerRight,
              child: TextButton(
                onPressed: () {
                  setState(() => isExpanded = !isExpanded);
                },
                child: Text(isExpanded ? "See Less" : "See More"),
              ),
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
