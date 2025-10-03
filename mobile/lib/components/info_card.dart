import 'package:flutter/material.dart';

class InfoCard extends StatefulWidget {
  final String date;
  final String diagnosis;
  final String doctor;
  final String hospital;
  final String remarks;
  final String status; 

  const InfoCard({
    super.key,
    required this.date,
    required this.diagnosis,
    required this.doctor,
    required this.hospital,
    this.remarks = "This is the sample remarks Dolor id id ea est adipisicing ut mollit in sint cillum tempor. Aute minim ad ex sit id anim ex fugiat proident. Lorem fugiat tempor magna esse cupidatat sunt adipisicing cupidatat ipsum. Sint quis ut sunt ut aliqua occaecat Lorem culpa excepteur. Fugiat est qui ad eiusmod labore officia veniam sit non minim est reprehenderit. Irure duis proident aute eiusmod officia tempor laborum magna nostrud dolore fugiat. Officia exercitation dolore deserunt reprehenderit veniam velit officia officia elit voluptate labore mollit amet sint.",
    this.status = "Active", // default value
  });

  @override
  State<InfoCard> createState() => _InfoCardState();
}

class _InfoCardState extends State<InfoCard> {
  bool _expanded = false;

  @override
  Widget build(BuildContext context) {
    Color statusBg;
    Color statusText;

    if (widget.status == "Active") {
      statusBg = Colors.yellow.shade200;
      statusText = Colors.brown;
    } else if (widget.status == "Recovered") {
      statusBg = Colors.green.shade100;
      statusText = Colors.green;
    } else {
      statusBg = Colors.grey.shade200;
      statusText = Colors.black;
    }

    return Card(
      margin: const EdgeInsets.symmetric(vertical: 8),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
        side: const BorderSide(color: Color(0xFF296E5B)),
      ),
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
          Text(
            widget.date,
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: Color(0xFF296E5B),
            ),
          ),
          const SizedBox(height: 6),
            Text("Diagnosis: ${widget.diagnosis}"),
            Text("Doctor: ${widget.doctor}"),
            Text("Hospital: ${widget.hospital}"),

            // Expanded section
            if (_expanded) ...[
              Text("Remarks: ${widget.remarks}"),
              const SizedBox(height: 6),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: statusBg,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Text(
                  "Status: ${widget.status}",
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    color: statusText,
                  ),
                ),
              ),
            ],

            // See More / See Less button
            Align(
              alignment: Alignment.centerRight,
              child: TextButton(
                onPressed: () {
                  setState(() => _expanded = !_expanded);
                },
                child: Text(
                  _expanded ? "See Less" : "See More",
                  style: const TextStyle(color: Color(0xFF296E5B)),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
