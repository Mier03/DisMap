<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DisMap Team</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-g-dark { background-color: #296E5B; }
        .text-g-light { color: #a0aec0; }
        .bg-g-light { background-color: #e2e8f0; }
        .text-g-dark { color: #296E5B; }
        .border-g-light { border-color: #a0aec0; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Compact Team Footer Section -->
    <footer class="bg-g-dark text-white py-8 px-6 opacity-0 transform translate-y-12 transition-all duration-800 ease-out" id="team-section">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold mb-2 opacity-0 transform translate-y-8 transition-all duration-600 ease-out">Our Team</h2>
                <p class="text-g-light text-sm opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-100">
                    The people behind DisMap
                </p>
            </div>
            
            <div class="relative mb-6 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-200">
                <div class="flex justify-center items-center space-x-6">
                    <!-- Team Member 1 -->
                    <div class="text-center team-member transition-all duration-500 transform cursor-pointer" 
                         data-member="0"
                         onclick="openMemberModal(0)">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar overflow-hidden hover:scale-110">
                            <img src="{{ asset('images/EMA.svg') }}" alt="Elaisha Mae Arias" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Elaisha Mae Arias</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Developer</p>
                    </div>
                    
                    <!-- Team Member 2 -->
                    <div class="text-center team-member transition-all duration-500 transform cursor-pointer" 
                         data-member="1"
                         onclick="openMemberModal(1)">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar overflow-hidden hover:scale-110">
                            <img src="{{ asset('images/AJC.svg') }}" alt="Adrianne John Camus" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Adrianne John Camus</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Developer</p>
                    </div>
                    
                    <!-- Team Member 3 -->
                    <div class="text-center team-member transition-all duration-500 transform cursor-pointer" 
                         data-member="2"
                         onclick="openMemberModal(2)">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar overflow-hidden hover:scale-110">
                            <img src="{{ asset('images/AM.svg') }}" alt="Angelina Mier" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Angelina Mier</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Project Lead</p>
                    </div>
                    
                    <!-- Team Member 4 -->
                    <div class="text-center team-member transition-all duration-500 transform cursor-pointer" 
                         data-member="3"
                         onclick="openMemberModal(3)">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar overflow-hidden hover:scale-110">
                            <img src="{{ asset('images/RS.svg') }}" alt="Rainelyn Sungahid" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Rainelyn Sungahid</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Developer</p>
                    </div>
                    
                    <!-- Team Member 5 -->
                    <div class="text-center team-member transition-all duration-500 transform cursor-pointer" 
                         data-member="4"
                         onclick="openMemberModal(4)">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar overflow-hidden hover:scale-110">
                            <img src="{{ asset('images/MLS.svg') }}" alt="Mitch Lauren Santillan" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Mitch Lauren Santillan</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Developer</p>
                    </div>
                </div>

                <!-- Navigation buttons -->
                <button class="absolute left-2 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300" onclick="changeHighlight(-1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300" onclick="changeHighlight(1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center gap-2 mb-4 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-300">
                <button class="w-2 h-2 rounded-full bg-white transition-all duration-300" onclick="goToHighlight(0)" id="highlight-indicator-0"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(1)" id="highlight-indicator-1"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(2)" id="highlight-indicator-2"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(3)" id="highlight-indicator-3"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(4)" id="highlight-indicator-4"></button>
            </div>

             <!-- Footer Bottom -->
            <div class="border-t border-g-light/20 pt-4 text-center opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-400">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                    <div class="text-left">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-g-light text-xs"></i>
                            <a href="mailto:dismap@gmail.com">dismap@gmail.com</a>
                             <i class="fab fa-facebook-square text-g-light text-xs"></i>
                            <a href="https://web.facebook.com/people/DisMap/61575644438300/?rdid=JkeC2KC8ZslXZRPo&share_url=https%3A%2F%2Fweb.facebook.com%2Fshare%2F1DMuBZRASi%2F%3F_rdc%3D1%26_rdr">DisMap</a>
                        </div>
                    </div>
                    <div class="text-g-light text-xs">
                        <p>&copy; 2025 DisMap. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Team Member Modal - Narrow Width, Taller Height -->
    <div id="memberModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-xl max-w-xs w-full mx-4 transform scale-95 transition-transform duration-300 shadow-xl" style="min-height: 480px;">
            <!-- Close button -->
            <div class="flex justify-end p-4">
                <button onclick="closeMemberModal()" class="text-gray-500 hover:text-gray-700 w-6 h-6 flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="px-5 pb-6 -mt-2 h-full flex flex-col">
                <!-- Profile section -->
                <div class="text-center mb-6">
                    <img id="modalImage" src="" alt="" class="w-28 h-28 rounded-full mx-auto mb-4 object-cover border-2 border-g-light">
                    <h2 id="modalName" class="text-xl font-bold text-g-dark mb-1"></h2>
                    <p id="modalRole" class="text-g-light text-sm"></p>
                </div>
                
                <!-- Compact info layout with more vertical space -->
                <div class="space-y-4 flex-1">
                    <!-- Contact -->
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-g-light mt-0.5 w-4 mr-3 text-xs"></i>
                        <div class="flex-1">
                            <p id="modalEmail" class="text-g-dark text-sm font-medium"></p>
                            <p id="modalPhone" class="text-g-dark text-xs mt-1 text-gray-600"></p>
                        </div>
                    </div>
                    
                    <!-- Responsibilities -->
                    <div class="flex items-start">
                        <i class="fas fa-tasks text-g-light mt-0.5 w-4 mr-3 text-xs"></i>
                        <div class="flex-1">
                            <p class="text-g-dark text-xs font-semibold mb-1">Responsibilities</p>
                            <p id="modalResponsibilities" class="text-g-dark text-sm leading-relaxed"></p>
                        </div>
                    </div>
                    
                    <!-- Bio -->
                    <div class="flex items-start">
                        <i class="fas fa-quote-left text-g-light mt-0.5 w-4 mr-3 text-xs"></i>
                        <div class="flex-1">
                            <p class="text-g-dark text-xs font-semibold mb-1">About</p>
                            <p id="modalBio" class="text-g-dark text-sm italic leading-relaxed"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const teamMembersData = [
            {
                name: 'Elaisha Mae Arias',
                role: 'UI/UX Designer & Front-end Developer',
                image: "{{ asset('images/EMA.svg') }}",
                email: 'elaishaarias@gmail.com',
                responsibilities: 'UI/UX design using Figma and front-end development for web and mobile applications.',
                bio: 'Passionate about creating intuitive and beautiful user interfaces that enhance user experience and drive engagement.'
            },
            {
                name: 'Adrianne John Camus',
                role: 'UI/UX Designer & Frontiend Developer',
                image: "{{ asset('images/AJC.svg') }}",
                email: 'adriannejohncamusofficial@gmail.com',
                responsibilities: 'UI/UX design using Figma and front-end development with modern frameworks.',
                bio: 'Specializes in creating engaging interactive experiences and smooth animations that make products delightful to use.'
            },
            {
                name: 'Angelina Mier',
                role: 'Project Lead',
                image: "{{ asset('images/AM.svg') }}",
                email: 'amierangelina03@gmail.com',
                responsibilities: 'Managing the team, leading the group, and contributing to back-end development.',
                bio: 'Ensures projects are delivered on time, within budget, and exceed client expectations through effective leadership.'
            },
            {
                name: 'Rainelyn Sungahid',
                role: 'Back-end/Front-end Developer',
                image: "{{ asset('images/RS.svg') }}",
                email: 'rainelynsungahid@gmail.com',
                responsibilities: 'Back-end development with some front-end development experience.',
                bio: 'Builds robust, scalable, and secure backend systems that power our applications and handle millions of requests.'
            },
            {
                name: 'Mitch Lauren Santillan',
                role: 'Back-end/Front-end Developer',
                image: "{{ asset('images/MLS.svg') }}",
                email: 'santillanmitchlauren@gmail.com',
                responsibilities: 'Back-end development with some front-end development experience.',
                bio: 'Focuses on creating secure, high-performance backend solutions with clean code and industry best practices.'
            }
        ];

        // Team highlight functionality
        function initTeamHighlight() {
            let currentHighlight = 0;
            const totalHighlights = teamMembersData.length;
            let highlightInterval;

            function showHighlight(index) {
                currentHighlight = index;
                
                const teamMembers = document.querySelectorAll('.team-member');
                teamMembers.forEach(member => {
                    const avatar = member.querySelector('.team-avatar');
                    const name = member.querySelector('.team-name');
                    const role = member.querySelector('.team-role');
                    
                    member.classList.remove('scale-110', 'opacity-100');
                    member.classList.add('opacity-60', 'scale-90');
                    avatar.classList.remove('w-16', 'h-16', 'border-4', 'border-white', 'shadow-xl', 'bg-white', 'text-g-dark');
                    name.classList.remove('text-white', 'font-bold', 'text-sm');
                    role.classList.remove('text-white', 'text-xs');
                });
                
                const currentMember = document.querySelector(`[data-member="${index}"]`);
                if (currentMember) {
                    const avatar = currentMember.querySelector('.team-avatar');
                    const name = currentMember.querySelector('.team-name');
                    const role = currentMember.querySelector('.team-role');
                    
                    currentMember.classList.remove('opacity-60', 'scale-90');
                    currentMember.classList.add('scale-110', 'opacity-100');
                    avatar.classList.add('w-16', 'h-16', 'border-4', 'border-white', 'shadow-xl', 'bg-white', 'text-g-dark');
                    name.classList.add('text-white', 'font-bold', 'text-sm');
                    role.classList.add('text-white', 'text-xs');
                }
                
                for (let i = 0; i < totalHighlights; i++) {
                    const indicator = document.getElementById(`highlight-indicator-${i}`);
                    if (i === index) {
                        indicator.classList.remove('bg-white/30', 'hover:bg-white/50');
                        indicator.classList.add('bg-white');
                    } else {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-white/30', 'hover:bg-white/50');
                    }
                }
            }

            window.changeHighlight = function(direction) {
                let newHighlight = currentHighlight + direction;
                
                if (newHighlight < 0) {
                    newHighlight = totalHighlights - 1; 
                } else if (newHighlight >= totalHighlights) {
                    newHighlight = 0;
                }
                
                showHighlight(newHighlight);
                resetHighlightAutoSlide();
            }

            window.goToHighlight = function(index) {
                showHighlight(index);
                resetHighlightAutoSlide();
            }

            function startHighlightAutoSlide() {
                highlightInterval = setInterval(() => {
                    window.changeHighlight(1); 
                }, 3000); 
            }

            function resetHighlightAutoSlide() {
                clearInterval(highlightInterval);
                startHighlightAutoSlide();
            }

            showHighlight(0); 
            startHighlightAutoSlide();
            
            const teamSection = document.querySelector('.relative');
            if (teamSection) {
                teamSection.addEventListener('mouseenter', () => {
                    clearInterval(highlightInterval);
                });
                
                teamSection.addEventListener('mouseleave', () => {
                    startHighlightAutoSlide();
                });
            }
        }

        // Modal functionality
        function openMemberModal(index) {
            const member = teamMembersData[index];
            const modal = document.getElementById('memberModal');
            
            // Populate modal with member data
            document.getElementById('modalImage').src = member.image;
            document.getElementById('modalName').textContent = member.name;
            document.getElementById('modalRole').textContent = member.role;
            document.getElementById('modalEmail').textContent = member.email;
            document.getElementById('modalPhone').textContent = member.phone;
            document.getElementById('modalResponsibilities').textContent = member.responsibilities;
            document.getElementById('modalBio').textContent = member.bio;
            
            // Show modal with animation
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.remove('scale-95');
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function closeMemberModal() {
            const modal = document.getElementById('memberModal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.remove('opacity-100', 'pointer-events-auto');
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('memberModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMemberModal();
            }
        });

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initTeamHighlight();
            
            // Animate team section into view
            setTimeout(() => {
                const teamSection = document.getElementById('team-section');
                teamSection.classList.remove('opacity-0', 'translate-y-12');
                
                // Animate child elements
                const animatedElements = teamSection.querySelectorAll('[class*="opacity-0"]');
                animatedElements.forEach(el => {
                    el.classList.remove('opacity-0', 'translate-y-8');
                });
            }, 500);
        });
    </script>
</body>
</html>