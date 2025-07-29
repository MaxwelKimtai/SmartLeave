<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave - Step-by-Step</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/request_leave.css">
</head>
<body>
    <div class="stepped-form-container">
        <div class="left-panel">
            <div class="logo">
                <img src="assets/logo.png" alt="Smart Leave Logo"> <span>SMART LEAVE</span>
            </div>
            <div class="illustration-area">
                <h3>Leave Application Automated</h3>
                <img src="assets/form.png" alt="Illustration" class="illustration"> 
            </div>
        </div>
        
        <div class="right-panel">
            <div class="progress-bar-container">
                <div class="progress-step current" data-step="1">
                    <span class="step-circle">1</span>
                    <span class="step-text">Leave Info</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="2">
                    <span class="step-circle">2</span>
                    <span class="step-text">Details</span>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step" data-step="3">
                    <span class="step-circle">3</span>
                    <span class="step-text">Confirmation</span>
                </div>
            </div>

            <div class="form-content-wrapper"> 
                <form id="multiStepLeaveForm" action="submit_leave.php" method="POST" enctype="multipart/form-data">
                    <div class="form-step current" data-step="1">
                        <h3><i class="fas fa-info-circle"></i> Basic Leave Information</h3>
                        
                        <div class="form-group floating-label">
                            <input type="text" id="leave_type_display" readonly>
                            <label for="leave_type_select">Leave Type</label>
                            <select id="leave_type_select" name="leave_type" required>
                                <option value="" disabled selected></option>
                                <option value="annual">Annual Leave</option>
                                <option value="sick">Sick Leave</option>
                                <option value="casual">Casual Leave</option>
                                <option value="maternity">Maternity Leave</option>
                                <option value="paternity">Paternity Leave</option>
                                <option value="bereavement">Bereavement Leave</option>
                            </select>
                            <i class="fas fa-caret-down input-icon"></i>
                        </div>

                        <div class="form-group floating-label">
                            <label for="start_date"></label>
                            <input type="date" id="start_date" name="start_date" required>
                            <i class="fas fa-calendar-alt input-icon"></i>
                        </div>

                        <div class="form-group floating-label">
                            <label for="end_date"></label>
                            <input type="date" id="end_date" name="end_date" required>
                            <i class="fas fa-calendar-alt input-icon"></i>
                        </div>

                        <div class="form-group floating-label">
                            <label for="num_days">Number of Days</label>
                            <input type="text" id="num_days" name="num_days" readonly>
                            <i class="fas fa-calculator input-icon"></i>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="next-button primary-button">Next <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div class="form-step" data-step="2">
                        <h3><i class="fas fa-file-alt"></i> Reason & Attachments</h3>
                        <div class="form-group floating-label">
                            <label for="reason">Reason for Leave</label>
                            <textarea id="reason" name="reason" rows="6" required></textarea>
                            <i class="fas fa-pencil-alt input-icon textarea-icon"></i>
                        </div>

                        <div class="form-group file-upload-group">
                            <label for="attachment">Upload Attachment (Optional)</label>
                            <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png">
                            <div class="custom-file-upload">
                                <i class="fas fa-paperclip"></i> Choose File
                                <span id="file-name">No file chosen</span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="prev-button secondary-button"><i class="fas fa-arrow-left"></i> Previous</button>
                            <button type="button" class="next-button primary-button">Next <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div class="form-step" data-step="3">
                        <h3><i class="fas fa-check-circle"></i> Review & Confirm</h3>
                        <div class="confirmation-summary">
                            <p><strong>Leave Type:</strong> <span id="confirm_leave_type"></span></p>
                            <p><strong>Start Date:</strong> <span id="confirm_start_date"></span></p>
                            <p><strong>End Date:</strong> <span id="confirm_end_date"></span></p>
                            <p><strong>Number of Days:</strong> <span id="confirm_num_days"></span></p>
                            <p><strong>Reason:</strong> <span id="confirm_reason"></span></p>
                            <p><strong>Attachment:</strong> <span id="confirm_attachment"></span></p>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="prev-button secondary-button"><i class="fas fa-arrow-left"></i> Previous</button>
                            <button type="submit" class="submit-button primary-button">Submit Application <i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </form>
            </div></div>
    </div>

    <div id="toast-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('multiStepLeaveForm');
            const formSteps = document.querySelectorAll('.form-step');
            const progressSteps = document.querySelectorAll('.progress-step');
            const nextButtons = document.querySelectorAll('.next-button');
            const prevButtons = document.querySelectorAll('.prev-button');
            const toastContainer = document.getElementById('toast-container');

            let currentStep = 1;

            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const numDaysInput = document.getElementById('num_days');
            const leaveTypeSelect = document.getElementById('leave_type_select');
            const leaveTypeDisplay = document.getElementById('leave_type_display');
            const reasonInput = document.getElementById('reason');
            const attachmentInput = document.getElementById('attachment');
            const fileNameSpan = document.getElementById('file-name');

            // --- Floating Label Logic ---
            document.querySelectorAll('.form-group.floating-label input, .form-group.floating-label textarea, .form-group.floating-label select').forEach(input => {
                const parentGroup = input.closest('.form-group');

                // For the custom select (leave_type_display and leave_type_select)
                if (input.tagName === 'SELECT') {
                    const updateSelectDisplay = () => {
                        leaveTypeDisplay.value = leaveTypeSelect.options[leaveTypeSelect.selectedIndex].textContent;
                        if (leaveTypeSelect.value) {
                            parentGroup.classList.add('has-content');
                        } else {
                            parentGroup.classList.remove('has-content');
                        }
                    };
                    
                    leaveTypeSelect.addEventListener('change', updateSelectDisplay);
                    // Ensure clicking on the display input focuses the actual select
                    leaveTypeDisplay.addEventListener('click', () => {
                        leaveTypeSelect.focus();
                        // Optionally trigger dropdown if possible (browser dependent)
                        const event = new MouseEvent('mousedown', { bubbles: true, cancelable: true, view: window });
                        leaveTypeSelect.dispatchEvent(event);
                    });
                    
                    // Initial state for select
                    updateSelectDisplay();

                } else {
                    // For other inputs (text, date, textarea)
                    // Check initial value on load
                    if (input.value) {
                        parentGroup.classList.add('has-content');
                    }

                    input.addEventListener('focus', () => parentGroup.classList.add('is-focused'));
                    input.addEventListener('blur', () => {
                        parentGroup.classList.remove('is-focused');
                        if (input.value) {
                            parentGroup.classList.add('has-content');
                        } else {
                            parentGroup.classList.remove('has-content');
                        }
                    });
                }
            });

            // --- Auto-calculate Number of Days ---
            const calculateDays = () => {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                // Clear validation styles on recalculate
                startDateInput.classList.remove('is-invalid');
                endDateInput.classList.remove('is-invalid');

                if (startDateInput.value && endDateInput.value && endDate >= startDate) {
                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const dayDiff = timeDiff / (1000 * 3600 * 24) + 1; // +1 to include start day
                    numDaysInput.value = `${dayDiff} Day(s)`;
                    // Ensure numDaysInput also triggers floating label
                    numDaysInput.closest('.form-group').classList.add('has-content');
                } else if (startDateInput.value || endDateInput.value) {
                    numDaysInput.value = 'Invalid Date Range';
                    numDaysInput.closest('.form-group').classList.add('has-content');
                } else {
                    numDaysInput.value = '';
                    numDaysInput.closest('.form-group').classList.remove('has-content');
                }
            };

            startDateInput.addEventListener('change', calculateDays);
            endDateInput.addEventListener('change', calculateDays);
            // Also call on DOMContentLoaded if dates might be pre-filled
            calculateDays();


            // --- File Upload Display ---
            attachmentInput.addEventListener('change', () => {
                if (attachmentInput.files.length > 0) {
                    fileNameSpan.textContent = attachmentInput.files[0].name;
                } else {
                    fileNameSpan.textContent = 'No file chosen';
                }
            });

            // --- Toast Notification Functionality ---
            const showToast = (message, type = 'success') => {
                const toast = document.createElement('div');
                toast.classList.add('toast', type);
                toast.textContent = message;
                toastContainer.appendChild(toast);

                void toast.offsetWidth; // Trigger reflow for CSS transition
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    toast.addEventListener('transitionend', () => {
                        toast.remove();
                    }, { once: true });
                }, 3000);
            };

            // --- Step Navigation Logic ---
            function updateFormSteps() {
                formSteps.forEach(step => {
                    step.classList.remove('current');
                    if (parseInt(step.dataset.step) === currentStep) {
                        step.classList.add('current');
                    }
                });
                updateProgressBar();
                populateConfirmationSummary(); // Update summary on each step change
            }

            function updateProgressBar() {
                progressSteps.forEach((step, index) => {
                    if (index < currentStep) {
                        step.classList.add('current');
                        if (index < currentStep - 1) {
                            step.classList.add('completed');
                        } else {
                            step.classList.remove('completed');
                        }
                    } else {
                        step.classList.remove('current', 'completed');
                    }
                });
            }

            function validateStep(step) {
                let isValid = true;
                const currentFormStep = form.querySelector(`.form-step[data-step="${step}"]`);
                // Get only visible required inputs within the current step
                const inputs = currentFormStep.querySelectorAll('input[required]:not([type="hidden"]), select[required], textarea[required]');

                inputs.forEach(input => {
                    const actualInputValue = (input.tagName === 'SELECT') ? input.value : input.value.trim();

                    if (!actualInputValue) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        // Special handling for the select display input
                        if (input.id === 'leave_type_select') {
                            leaveTypeDisplay.classList.add('is-invalid');
                        }
                    } else {
                        input.classList.remove('is-invalid');
                        if (input.id === 'leave_type_select') {
                            leaveTypeDisplay.classList.remove('is-invalid');
                        }
                    }
                });

                if (step === 1) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    // Check if both dates are selected and if end date is before start date
                    if (startDateInput.value && endDateInput.value && endDate < startDate) {
                        showToast('End date cannot be before start date.', 'error');
                        startDateInput.classList.add('is-invalid');
                        endDateInput.classList.add('is-invalid');
                        isValid = false;
                    } else if (startDateInput.value && endDateInput.value) { // Clear invalid if dates are now valid
                         startDateInput.classList.remove('is-invalid');
                         endDateInput.classList.remove('is-invalid');
                    }
                }
                
                return isValid;
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        updateFormSteps();
                    } else {
                        showToast('Please fill in all required fields for this step.', 'error');
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', () => {
                    currentStep--;
                    updateFormSteps();
                });
            });

            // Populate confirmation summary
            function populateConfirmationSummary() {
                if (currentStep === 3) {
                    document.getElementById('confirm_leave_type').textContent = leaveTypeSelect.options[leaveTypeSelect.selectedIndex].textContent || 'N/A';
                    document.getElementById('confirm_start_date').textContent = startDateInput.value || 'N/A';
                    document.getElementById('confirm_end_date').textContent = endDateInput.value || 'N/A';
                    document.getElementById('confirm_num_days').textContent = numDaysInput.value || 'N/A';
                    document.getElementById('confirm_reason').textContent = reasonInput.value || 'N/A';
                    document.getElementById('confirm_attachment').textContent = attachmentInput.files.length > 0 ? attachmentInput.files[0].name : 'No file attached';
                }
            }

            // Initial setup
            updateFormSteps();
            calculateDays(); // Calculate days on load in case dates are pre-filled

            // --- Form Submission Logic (Only on Step 3) ---
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                if (currentStep === 3) {
                    if (!validateStep(currentStep)) {
                        showToast('Please review and fill in any missing details.', 'error');
                        return;
                    }

                    const formData = new FormData(form);
                    formData.delete('leave_type_display'); // Remove the display input from form data

                    try {
                        const response = await fetch('submit_leave.php', { // Ensure submit_leave.php exists
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            showToast('Leave request submitted successfully!', 'success');
                            form.reset();
                            // Reset floating labels
                            document.querySelectorAll('.form-group.floating-label').forEach(group => {
                                group.classList.remove('has-content', 'is-focused');
                            });
                            // Re-initialize custom select display
                            leaveTypeSelect.value = ""; // Reset actual select value
                            leaveTypeDisplay.value = ""; // Reset display value
                            fileNameSpan.textContent = 'No file chosen';
                            numDaysInput.value = '';
                            currentStep = 1;
                            updateFormSteps();
                        } else {
                            showToast(result.message || 'Failed to submit leave request. Please try again.', 'error');
                        }
                    } catch (error) {
                        console.error('Error submitting form:', error);
                        showToast('An unexpected error occurred. Please try again later.', 'error');
                    }
                } else {
                    showToast('Please complete all steps before submitting.', 'error');
                }
            });
        });
    </script>
</body>
</html>