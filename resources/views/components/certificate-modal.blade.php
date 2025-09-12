@props(['certification' => ''])

<!-- Certificate Modal -->
<div id="certificateModal" class="fixed inset-0 flex items-center justify-center bg-g-dark bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-md shadow-lg w-80 md:w-96 max-h-[80vh] flex flex-col overflow-hidden">
        <!-- Green Header -->
        <div class="bg-g-dark p-4 flex justify-between items-center">
            <h2 class="text-white text-xl font-bold">Certificate</h2>
            <button onclick="closeCertificateModal()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Certificate Image -->
        <div id="certificateContent" class="flex-1 flex justify-center items-center bg-gray-100 p-4 overflow-auto">
            <img src="/mnt/data/2e07a899-d7f6-4422-89cc-74fb018c0815.png" 
                 alt="Certificate" 
                 class="m-w-600 m-h-700">
        </div>
    </div>
</div>

<script>
    // Certificate modal functions
    function viewCertificate(certification) {
        const modal = document.getElementById('certificateModal');
        const content = document.getElementById('certificateContent');
        
        // Check if certification is a URL (image) or text
        if (certification.match(/\.(jpeg|jpg|gif|png|webp|bmp|svg)$/i)) {
            // It's an image
            content.innerHTML = `
                <div class="text-center">
                    <img src="${certification}" alt="Certificate" class="max-w-full h-auto mx-auto rounded" onerror="this.style.display='none'; document.getElementById('certificateError').style.display='block'">
                    <div id="certificateError" style="display: none;" class="text-red-500 mt-2">
                        Failed to load image. <a href="${certification}" target="_blank" class="text-blue-600 hover:underline">Try opening the link directly</a>.
                    </div>
                    <div class="mt-4">
                        <a href="${certification}" target="_blank" class="text-blue-600 hover:underline">Open in new tab</a>
                    </div>
                </div>
            `;
        } else if (certification.startsWith('http')) {
            // It's a URL but not an image
            content.innerHTML = `
                <div class="text-center">
                    <p class="text-gray-700 mb-4">Certificate link:</p>
                    <a href="${certification}" target="_blank" class="text-blue-600 hover:underline break-words">${certification}</a>
                    <div class="mt-4">
                        <a href="${certification}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Open Link</a>
                    </div>
                </div>
            `;
        } else if (certification) {
            // It's text
            content.innerHTML = `
                <div class="bg-gray-100 p-4 rounded">
                    <p class="text-gray-700 whitespace-pre-wrap break-words">${certification}</p>
                </div>
            `;
        } else {
            // No certification available
            content.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>No certificate available</p>
                </div>
            `;
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeCertificateModal() {
        document.getElementById('certificateModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }

    // Close modal when clicking outside
    document.getElementById('certificateModal').addEventListener('click', function(e) {
        if (e.target.id === 'certificateModal') {
            closeCertificateModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCertificateModal();
        }
    });
</script>