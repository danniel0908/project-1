<style>
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 50;
        backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border-radius: 0.75rem;
        max-width: 90%;
        width: 600px;
        max-height: 80vh;
        z-index: 51;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        flex-direction: column;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .modal-backdrop.active {
        opacity: 1;
    }



    .modal-header {
        padding: 2rem 2rem 1rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #003300;
    }

    .modal-close {
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 0.5rem;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: #1f2937;
    }

    .modal-content {
        flex: 1;
        overflow-y: auto;
        padding: 2rem;
        color: #374151;
        line-height: 1.6;
    }

    .modal-content h3 {
        color: #003300;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 1.5rem 0 1rem;
    }

    .modal-content h3:first-child {
        margin-top: 0;
    }

    .modal-content p {
        margin-bottom: 1rem;
    }

    .modal-content ul {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
        list-style-type: disc;
    }

    .modal-content li {
        margin-bottom: 0.5rem;
    }

    .modal-footer {
        padding: 1rem 2rem 2rem 2rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
    }

    .modal-button {
        background-color: green;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .modal-button:hover {
        background-color: #047857;
    }

    .modal.active {
        opacity: 1;
        display: flex;
    }
</style>
<!-- Terms of Service Modal -->
<div id="termsModal" class="modal" style="display: none;">
    <div class="modal-header">
        <h2 class="modal-title">Terms of Service</h2>
        <button class="modal-close" data-close-modal="termsModal">&times;</button>
    </div>
    <div class="modal-content">
        <h3>1. Acceptance of Terms</h3>
        <p>By accessing and using this website, you accept and agree to be bound by the terms and provisions of this agreement.</p>

        <h3>2. Use License</h3>
        <p>Permission is granted to temporarily download one copy of the materials (information or software) on this website for personal, non-commercial transitory viewing only.</p>

        <h3>3. Disclaimer</h3>
        <p>The materials on this website are provided on an 'as is' basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

        <h3>4. Limitations</h3>
        <p>In no event shall we or our suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on this website.</p>

        <h3>5. Revisions and Errata</h3>
        <p>The materials appearing on this website could include technical, typographical, or photographic errors. We do not warrant that any of the materials on this website are accurate, complete, or current.</p>
    </div>
    <div class="modal-footer">
        <button class="modal-button" data-close-modal="termsModal">I Understand</button>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyModal" class="modal" style="display: none;">
    <div class="modal-header">
        <h2 class="modal-title">Privacy Policy</h2>
        <button class="modal-close" data-close-modal="privacyModal">&times;</button>
    </div>
    <div class="modal-content">
        <h3>1. Information We Collect</h3>
        <p>We collect information that you provide directly to us, including:</p>
        <ul>
            <li>Name and contact information</li>
            <li>Email address</li>
            <li>Phone number</li>
            <li>Account credentials</li>
        </ul>

        <h3>2. How We Use Your Information</h3>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Provide and maintain our services</li>
            <li>Notify you about changes to our services</li>
            <li>Allow you to participate in interactive features</li>
            <li>Provide customer support</li>
            <li>Monitor the usage of our services</li>
        </ul>

        <h3>3. Data Security</h3>
        <p>We implement appropriate security measures to protect against unauthorized access, alteration, disclosure, or destruction of your personal information.</p>

        <h3>4. Third-Party Services</h3>
        <p>We may employ third-party companies and individuals to facilitate our service, provide service on our behalf, perform service-related services, or assist us in analyzing how our service is used.</p>

        <h3>5. Your Rights</h3>
        <p>You have the right to access, update, or delete your personal information. You can exercise these rights by contacting us directly.</p>
    </div>
    <div class="modal-footer">
        <button class="modal-button" data-close-modal="privacyModal">I Understand</button>
    </div>
</div>

<!-- Modal Backdrop -->
<div class="modal-backdrop" style="display: none;"></div>

<!-- Modal JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backdrop = document.querySelector('.modal-backdrop');
        
        // Open modal function
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
                backdrop.style.display = 'block';
                document.body.style.overflow = 'hidden';
                
                // Trigger reflow to ensure transitions work
                modal.offsetHeight;
                backdrop.offsetHeight;
                
                // Add active class for fade in
                modal.classList.add('active');
                backdrop.classList.add('active');
            }
        }

        // Close modal function
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('active');
                backdrop.classList.remove('active');
                
                // Wait for transition to complete before hiding
                setTimeout(() => {
                    modal.style.display = 'none';
                    backdrop.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 200);
            }
        }

        // Event listeners for opening modals
        document.querySelectorAll('[data-modal-target]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal-target');
                openModal(modalId);
            });
        });

        // Event listeners for closing modals
        document.querySelectorAll('[data-close-modal]').forEach(closeButton => {
            closeButton.addEventListener('click', () => {
                const modalId = closeButton.getAttribute('data-close-modal');
                closeModal(modalId);
            });
        });

        // Close modal when clicking outside
        backdrop.addEventListener('click', () => {
            document.querySelectorAll('.modal.active').forEach(modal => {
                closeModal(modal.id);
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.active').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    });
</script>