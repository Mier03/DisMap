import 'package:flutter/material.dart';
import 'components/button.dart';
import 'components/textfield.dart';
import 'components/password_textfield.dart';
import 'components/logo_widget.dart';
import 'pages/records_page.dart';
import 'forgetpassword.dart'; 
import 'updatepassword.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import '../api_config.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

Future<void> _handleLogin() async {
  final username = usernameController.text.trim();
  final password = passwordController.text.trim();

  final url = Uri.parse('${ApiConfig.baseUrl}login');

  final response = await http.post(
    url,
    headers: {
      'Accept': 'application/json',
    },
    body: {
      'email': username,
      'password': password,
    },
  );

  final Map<String, dynamic> loginResponse = jsonDecode(response.body);

  if (response.statusCode == 200) {
    final String? token = loginResponse['token'];
    final Map<String, dynamic>? userData = loginResponse['user']; 

    if (userData == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Login failed: User data not found in response."),
          backgroundColor: Colors.red,
        ),
      );
      return;
    }
    
    final String? userType = userData['user_type']; 
    final dynamic rawUpdateFlag = userData['is_default_password'];

    if (userType != 'Patient') {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text("Access denied. Only patients can log in here."),
          backgroundColor: Colors.red,
        ),
      );
      return; 
    }
    
    bool isPasswordUpdateRequired = false;

    if (rawUpdateFlag is bool) {
      isPasswordUpdateRequired = rawUpdateFlag;
    } else if (rawUpdateFlag is int) {
      isPasswordUpdateRequired = rawUpdateFlag == 1;
    }
    
    if (token != null) {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('api_token', token);
    }
    
    if (isPasswordUpdateRequired) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const UpdatePasswordPage()),
      );
    } else {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const RecordsPage()),
      );
    }
  } else {
    // --- DEBUG: Print the error response to the console ---
    print('API Login Error Response (Status ${response.statusCode}): $loginResponse');
    // --------------------------------------------------------
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content:Text(loginResponse['message']),
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