import 'package:flutter/material.dart';
import '././button.dart';
import '././textfield.dart';
import '../api_config.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class EmailRequestModal extends StatefulWidget {
  final Function(String email) onSuccessfulRequest;

  const EmailRequestModal({super.key, required this.onSuccessfulRequest});

  @override
  State<EmailRequestModal> createState() => _EmailRequestModalState();
}

class _EmailRequestModalState extends State<EmailRequestModal> {
  final TextEditingController emailController = TextEditingController();
  bool _isLoading = false;

Future<void> _handleRequestResetLink() async {
  final email = emailController.text.trim();

  if (email.isEmpty) {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text("Please enter your email address"),
        backgroundColor: Colors.red,
      ),
    );
    return;
  }

  setState(() {
    _isLoading = true;
  });

  final url = Uri.parse('${ApiConfig.baseUrl}forgot-password-request');

  try {
    final response = await http.post(
      url,
      headers: { 'Accept': 'application/json' },
      body: { 'email': email },
    );

    final responseBody = jsonDecode(response.body);

    if (response.statusCode == 200) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("If the email exists, a reset link was sent."),
          backgroundColor: Colors.green,
        ),
      );

      // 👉 ONLY CALL THIS IF API SUCCESS
      widget.onSuccessfulRequest(email);
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(responseBody['message'] ?? "Failed to request link."),
          backgroundColor: Colors.red,
        ),
      );
    }
  } catch (e) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text("Network error: ${e.toString()}"),
        backgroundColor: Colors.red,
      ),
    );
  } finally {
    setState(() {
      _isLoading = false;
    });
  }
}

  @override
  Widget build(BuildContext context) {
    return Dialog(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
      child: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Forgot Password?',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.bold,
                color: Color(0xFF296E5B),
              ),
            ),
            const SizedBox(height: 10),
            const Text(
              'Enter your email to request a password reset link.',
              style: TextStyle(fontSize: 14, color: Colors.grey),
            ),
            const SizedBox(height: 20),
            CustomTextField(
              label: "Email Address",
              hintText: "Enter your email...",
              controller: emailController,
            ),
            const SizedBox(height: 20),
            _isLoading
                ? const Center(child: CircularProgressIndicator(color: Color(0xFF296E5B)))
                : Button(
                    text: "Request Reset Link",
                    onPressed: _handleRequestResetLink,
                  ),
            const SizedBox(height: 10),
            Center(
              child: GestureDetector(
                onTap: () => Navigator.pop(context),
                child: const Text(
                  "Cancel",
                  style: TextStyle(color: Colors.grey, fontWeight: FontWeight.w500),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}