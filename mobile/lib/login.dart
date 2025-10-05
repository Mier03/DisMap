import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;

import 'components/button.dart';
import 'components/textfield.dart';
import 'components/password_textfield.dart';
import 'components/logo_widget.dart';
import 'pages/records_page.dart';
import 'forgetpassword.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  bool isLoading = false;

  Future<void> _handleLogin() async {
    final email = usernameController.text.trim();
    final password = passwordController.text.trim();

    if (email.isEmpty || password.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Please fill in all fields"),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }

    setState(() => isLoading = true);

    try {
      // ⚠️ Change this IP to your computer's local IP address (not 127.0.0.1)
      final response = await http.post(
        Uri.parse("http://192.168.1.6:8000/api/login"),
        headers: {"Content-Type": "application/json"},
        body: jsonEncode({
          "email": email,
          "password": password,
        }),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final token = data['token'];
        final user = data['user'];

        // Print to console to verify successful login
        print("✅ Login successful");
        print("User: $user");
        print("Token: $token");

        // Navigate to records page
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const RecordsPage()),
        );
      } else {
        final error = jsonDecode(response.body);
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(error['error'] ?? "Invalid credentials"),
            backgroundColor: Colors.red,
          ),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text("Error connecting to server: $e"),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => isLoading = false);
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
                  "Welcome to Dismap!",
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF296E5B),
                  ),
                ),
                const SizedBox(height: 40),

                CustomTextField(
                  label: "Email",
                  hintText: "Enter your email...",
                  controller: usernameController,
                ),
                const SizedBox(height: 20),

                PasswordTextField(
                  label: "Password",
                  hintText: "Enter your password...",
                  controller: passwordController,
                ),
                const SizedBox(height: 30),

                Button(
                  text: isLoading ? "Signing In..." : "Sign In",
                  onPressed: isLoading ? null : () => _handleLogin(),
                ),
                const SizedBox(height: 20),

                GestureDetector(
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (_) => const ForgotPasswordPage()),
                    );
                  },
                  child: const Text(
                    "Forgot Password?",
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
