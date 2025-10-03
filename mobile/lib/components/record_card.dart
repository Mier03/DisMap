import 'package:flutter/material.dart';

class RecordCard extends StatelessWidget {
  final String date;
  final String diagnosis;
  final String doctor;
  final String hospital;
  final VoidCallback onSeeMore;

  const RecordCard({
    super.key,
    required this.date,
    required this.diagnosis,
    required this.doctor,
    required this.hospital,
    required this.onSeeMore,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: Color(0xFF296E5B)),
      ),
      margin: const EdgeInsets.symmetric(vertical: 8),
      elevation: 2,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              date,
              style: const TextStyle(
                color: Color(0xFF296E5B),
                fontWeight: FontWeight.bold,
                fontSize: 16,
              ),
            ),
            const SizedBox(height: 8),
            Text("Diagnosis: $diagnosis"),
            Text("Doctor: $doctor"),
            Text("Hospital: $hospital"),
            const SizedBox(height: 8),
            Align(
              alignment: Alignment.centerRight,
              child: TextButton(
                onPressed: onSeeMore,
                child: const Text("See More"),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
