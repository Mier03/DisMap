import 'package:flutter/material.dart';
import 'components/button.dart';
import 'components/password_textfield.dart';
import 'components/logo_widget.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import '../api_config.dart';

class ForgotPasswordPage extends StatefulWidget {
  final String email;
  
  const ForgotPasswordPage({super.key, required this.email});

  @override
  State<ForgotPasswordPage> createState() => _ForgotPasswordPageState();
}

class _ForgotPasswordPageState extends State<ForgotPasswordPage> {
  final TextEditingController newPasswordController = TextEditingController();
  final TextEditingController confirmPasswordController = TextEditingController();

  Future<void> _handleResetPassword() async {
    final newPassword = newPasswordController.text.trim();
    final confirmPassword = confirmPasswordController.text.trim();

    if (newPassword.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Please enter a new password"),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

    if (newPassword != confirmPassword) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Passwords do not match"),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

    final url = Uri.parse('${ApiConfig.baseUrl}reset-password'); 

    try {
      final response = await http.post(
        url,
        headers: {
          'Accept': 'application/json',
        },
        body: {
          'email': widget.email, 
          'password': newPassword, 
          'password_confirmation': confirmPassword,
        },
      );

      final Map<String, dynamic> responseBody = jsonDecode(response.body);

      if (response.statusCode == 200) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text("Password reset successfully! You can now log in."),
            backgroundColor: Colors.green,
          ),
        );

        Navigator.pop(context); 
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(responseBody['message'] ?? "Failed to reset password. Status: ${response.statusCode}"),
            backgroundColor: Colors.red,
          ),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("An error occurred: ${e.toString()}"),
          backgroundColor: Colors.red,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 40),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                const LogoWidget(),
                const SizedBox(height: 20),
                const Text(
                  "Reset Your Password",
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF296E5B),
                  ),
                ),
                const SizedBox(height: 40),
                
                // New Password field
                PasswordTextField(
                  label: "New Password",
                  hintText: "Enter your new password...",
                  controller: newPasswordController,
                ),
                const SizedBox(height: 20),

                // Confirm Password field
                PasswordTextField(
                  label: "Confirm Password",
                  hintText: "Confirm your new password...",
                  controller: confirmPasswordController,
                ),
                const SizedBox(height: 30),

                // Reset Password button
                Button(
                  text: "Reset Password", 
                  onPressed: _handleResetPassword,
                ),
                const SizedBox(height: 20),
                
                // Back to login 
                GestureDetector(
                  onTap: () {
                    Navigator.pop(context); 
                  },
                  child: const Text(
                    "Back to Login",
                    style: TextStyle(
                      color: Color(0xFF296E5B),
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}