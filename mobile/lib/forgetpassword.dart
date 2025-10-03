import 'package:flutter/material.dart';
import 'components/button.dart';
import 'components/textfield.dart';
import 'components/password_textfield.dart';
import 'components/logo_widget.dart';

class ForgotPasswordPage extends StatefulWidget {
  const ForgotPasswordPage({super.key});

  @override
  State<ForgotPasswordPage> createState() => _ForgotPasswordPageState();
}

class _ForgotPasswordPageState extends State<ForgotPasswordPage> {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController newPasswordController = TextEditingController();
  final TextEditingController confirmPasswordController = TextEditingController();

  void _handleResetPassword() {
    final username = usernameController.text.trim();
    final newPassword = newPasswordController.text.trim();
    final confirmPassword = confirmPasswordController.text.trim();

    if (username.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Please enter your username"),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

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

   
    // For now, show success message and navigate back
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text("Password reset successfully!"),
        backgroundColor: Colors.green,
      ),
    );

    // Navigate back to login page after successful reset
    Navigator.pop(context);
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
                  "Welcome to Dismap!",
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF296E5B),
                  ),
                ),
                const SizedBox(height: 40),

                // Username field
                CustomTextField(
                  label: "Username",
                  hintText: "Enter your username...",
                  controller: usernameController,
                ),
                const SizedBox(height: 20),

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
                  hintText: "Enter your password...",
                  controller: confirmPasswordController,
                ),
                const SizedBox(height: 30),

                // Reset Password button
                Button(
                  text: "Sign In", // You can change this to "Reset Password" if preferred
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