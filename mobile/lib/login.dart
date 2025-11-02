import 'package:flutter/material.dart';
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

  void _handleLogin() {
    final username = usernameController.text.trim();
    final password = passwordController.text.trim();

    if (username == "test" && password == "test123") {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const RecordsPage()),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Invalid username or password"),
          backgroundColor: Colors.red,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
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
                  label: "Username",
                  hintText: "Enter your username...",
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
                  text: "Sign In",
                  onPressed: _handleLogin,
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