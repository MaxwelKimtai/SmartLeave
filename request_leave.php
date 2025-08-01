<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap');

        /* Custom CSS Variables for Dashboard Theme */
        :root {
            --theme-primary: #f6ad55; /* Yellow-orange accent */
            --theme-bg-dark: #2d3748; /* Dark gray for dashboard bg */
            --theme-card-bg: rgba(45, 55, 72, 0.7); /* Semi-transparent card bg */
            --theme-card-border: #4a5568; /* Dark border */
            --theme-text-light: #cbd5e0; /* Light gray text */
            --theme-text-muted: #a0aec0; /* Muted gray text */
            --theme-input-bg: rgba(74, 85, 104, 0.4);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--theme-bg-dark);
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-position: center;
            color: var(--theme-text-light);
            overflow: hidden; /* Prevent scrolling */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .leave-form-card {
            width: 100%;
            max-width: 550px; /* Adjusted width to match the screenshot */
            background-color: var(--theme-card-bg);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            border: 1px solid var(--theme-card-border);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .step-indicator-item div {
            background-color: var(--theme-card-border);
            color: var(--theme-text-muted);
        }
        .step-indicator-item.active div, .step-indicator-item.active span {
            background-color: var(--theme-primary);
            color: var(--theme-bg-dark);
        }
        .step-indicator-item.active span {
            color: var(--theme-text-light);
            background-color: transparent;
        }

        .form-input {
            width: 100%;
            background-color: var(--theme-input-bg);
            border: 1px solid var(--theme-card-border);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--theme-text-light);
            transition: all 0.3s;
        }
        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--theme-primary);
        }
        .form-input::placeholder {
            color: var(--theme-text-muted);
        }

        .button-primary {
            background-color: var(--theme-primary);
            color: var(--theme-bg-dark);
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.3s;
        }
        .button-primary:hover {
            background-color: #fbd38d;
        }

        .button-secondary {
            background-color: var(--theme-card-border);
            color: var(--theme-text-light);
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.3s;
        }
        .button-secondary:hover {
            background-color: #64748b;
        }

        /* Calendar Styles */
        .calendar-container {
            position: absolute;
            z-index: 50;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background-color: #1a202c;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
            border: 1px solid #374151;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .calendar-nav-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--theme-primary);
            padding: 0.25rem;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }
        .calendar-day-label {
            font-size: 0.75rem;
            color: var(--theme-text-muted);
            padding: 0.25rem;
        }
        .calendar-day {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
            color: var(--theme-text-light);
            background-color: transparent;
        }
        .calendar-day.active-day {
            background-color: var(--theme-primary);
            color: var(--theme-bg-dark);
            font-weight: bold;
        }
        .calendar-day:not(.active-day):hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .calendar-day.inactive {
            color: #6b7280;
            cursor: default;
        }
    </style>
</head>
<body>

    <div id="form-container" class="leave-form-card">
        
        <div class="flex justify-between items-center mb-6">
            <div id="step-1-indicator" class="flex flex-col items-center space-y-1 step-indicator-item active">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm bg-indigo-500 text-white transition-colors duration-300">
                    1
                </div>
                <span class="text-xs font-medium text-gray-100 transition-colors duration-300">
                    Basic Info
                </span>
            </div>
            <div id="step-line-1" class="flex-1 h-1 mx-2 bg-gray-700 transition-colors duration-300"></div>
            <div id="step-2-indicator" class="flex flex-col items-center space-y-1 step-indicator-item">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300">
                    2
                </div>
                <span class="text-xs font-medium transition-colors duration-300">
                    Purpose
                </span>
            </div>
            <div id="step-line-2" class="flex-1 h-1 mx-2 bg-gray-700 transition-colors duration-300"></div>
            <div id="step-3-indicator" class="flex flex-col items-center space-y-1 step-indicator-item">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300">
                    3
                </div>
                <span class="text-xs font-medium transition-colors duration-300">
                    Review
                </span>
            </div>
        </div>

        <h1 id="form-title" class="text-2xl font-extrabold mb-1">Apply for Leave</h1>
        <p id="form-description" class="text-sm text-gray-400 mb-6">
            Please provide your basic leave details.
        </p>

        <form id="leave-form" novalidate>
            <div id="step-1-panel" class="space-y-4">
                <div class="relative">
                    <label for="leaveType" class="block text-sm font-medium mb-1 text-gray-300">Leave Type</label>
                    <div id="leaveTypeInput" class="form-input flex items-center justify-between text-gray-200 cursor-pointer">
                        <span id="leaveTypeText">Choose a leave type</span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                    <div id="leaveTypeSelector" class="hidden absolute top-full left-0 right-0 mt-2 p-2 bg-gray-800 rounded-lg shadow-lg z-50 border border-gray-700">
                        </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label for="startDate" class="block text-sm font-medium mb-1 text-gray-300">Start Date</label>
                        <div id="startDateInput" class="form-input flex items-center justify-between text-gray-200 cursor-pointer">
                            <span id="startDateText" class="text-sm">dd/mm/yyyy</span>
                            <i class="far fa-calendar-alt text-lg text-gray-400"></i>
                        </div>
                        <div id="startDateCalendar" class="calendar-container hidden"></div>
                    </div>
                    <div class="relative">
                        <label for="endDate" class="block text-sm font-medium mb-1 text-gray-300">End Date</label>
                        <div id="endDateInput" class="form-input flex items-center justify-between text-gray-200 cursor-pointer">
                            <span id="endDateText" class="text-sm">dd/mm/yyyy</span>
                            <i class="far fa-calendar-alt text-lg text-gray-400"></i>
                        </div>
                        <div id="endDateCalendar" class="calendar-container hidden"></div>
                    </div>
                </div>
                <div>
                    <label for="numberOfDays" class="block text-sm font-medium mb-1 text-gray-300">Number of Days</label>
                    <input type="text" id="numberOfDays" name="numberOfDays" class="form-input cursor-not-allowed" value="0" readonly />
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="button" id="next-step-1-btn" class="button-primary">
                        Next
                    </button>
                </div>
            </div>

            <div id="step-2-panel" class="hidden space-y-4">
                <div>
                    <label for="reason" class="block text-sm font-medium mb-1 text-gray-300">Reason for Leave</label>
                    <textarea id="reason" name="reason" rows="3" class="form-input text-gray-200" placeholder="Enter a brief reason for your leave"></textarea>
                </div>
                <div>
                    <label for="handoverNotes" class="block text-sm font-medium mb-1 text-gray-300">Handover Notes <span class="text-xs text-gray-500 italic">(optional)</span></label>
                    <textarea id="handoverNotes" name="handoverNotes" rows="3" class="form-input text-gray-200" placeholder="Who will cover your tasks?"></textarea>
                </div>
                <div>
                    <label for="attachment" class="block text-sm font-medium mb-1 text-gray-300">Attachment <span class="text-xs text-gray-500 italic">(single file)</span></label>
                    <label for="file-upload" class="form-input cursor-pointer flex items-center justify-between text-gray-200">
                        <span id="fileName" class="truncate">Choose a file</span>
                        <i class="fas fa-cloud-upload-alt text-lg text-gray-400"></i>
                    </label>
                    <input id="file-upload" type="file" name="attachment" class="hidden" />
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" id="prev-step-2-btn" class="button-secondary">
                        Back
                    </button>
                    <button type="button" id="next-step-2-btn" class="button-primary">
                        Next
                    </button>
                </div>
            </div>

            <div id="step-3-panel" class="hidden">
                <div class="space-y-3 text-sm">
                    <h3 class="text-lg font-bold text-gray-100 mb-2">Review your application</h3>
                    <div class="flex items-center justify-between py-1 border-b border-gray-700">
                        <p class="font-semibold text-gray-400">Leave Type</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-leaveType" class="text-white"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-1 border-b border-gray-700">
                        <p class="font-semibold text-gray-400">Dates</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-dates" class="text-white"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-1 border-b border-gray-700">
                        <p class="font-semibold text-gray-400">Days</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-numberOfDays" class="text-white"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-start justify-between py-1 border-b border-gray-700">
                        <p class="font-semibold text-gray-400">Reason</p>
                        <div class="flex items-center space-x-2 text-right max-w-[60%]">
                            <span id="review-reason" class="text-white text-xs"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="2">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-start justify-between py-1">
                        <p class="font-semibold text-gray-400">Handover Notes</p>
                        <div class="flex items-center space-x-2 text-right max-w-[60%]">
                            <span id="review-handoverNotes" class="text-white text-xs"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="2">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-1 border-t border-gray-700">
                        <p class="font-semibold text-gray-400">Attachment</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-attachment" class="text-white truncate max-w-[100px]"></span>
                            <button type="button" class="edit-btn text-yellow-400 hover:text-yellow-300 text-xs" data-target-step="2">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="flex items-start mt-4">
                    <input type="checkbox" id="confirm-checkbox" name="confirm" class="mt-1 mr-2 w-4 h-4 text-yellow-500 bg-gray-800 border-gray-600 rounded focus:ring-yellow-500">
                    <label for="confirm-checkbox" class="text-gray-400 text-xs">I confirm this information is accurate.</label>
                </div>
                <p id="confirm-error" class="text-red-400 text-xs mt-2 hidden">Please confirm the information is accurate.</p>

                <div class="mt-8 flex justify-between">
                    <button type="button" id="prev-step-3-btn" class="button-secondary">
                        Back
                    </button>
                    <button type="submit" id="submit-btn" class="button-primary opacity-50 cursor-not-allowed" disabled>
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center p-4 z-[999]">
        <div class="relative bg-gray-800 bg-opacity-30 backdrop-filter backdrop-blur-lg p-6 rounded-2xl shadow-2xl text-center border border-gray-700 max-w-sm w-full">
            <button id="close-modal-btn" class="absolute top-3 right-3 text-gray-400 hover:text-yellow-500 transition-colors">
                <i class="fas fa-times-circle text-xl"></i>
            </button>
            <i class="fas fa-check-circle text-green-400 text-5xl mx-auto mb-3"></i>
            <h2 class="text-xl font-bold text-gray-100 mb-1">
                Application Submitted!
            </h2>
            <p class="text-gray-300 text-sm">
                Your leave request has been sent successfully.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Elements ---
            const leaveForm = document.getElementById('leave-form');
            const formTitle = document.getElementById('form-title');
            const formDescription = document.getElementById('form-description');

            const step1Panel = document.getElementById('step-1-panel');
            const step2Panel = document.getElementById('step-2-panel');
            const step3Panel = document.getElementById('step-3-panel');

            const nextStep1Btn = document.getElementById('next-step-1-btn');
            const prevStep2Btn = document.getElementById('prev-step-2-btn');
            const nextStep2Btn = document.getElementById('next-step-2-btn');
            const prevStep3Btn = document.getElementById('prev-step-3-btn');
            const submitBtn = document.getElementById('submit-btn');

            const leaveTypeInput = document.getElementById('leaveTypeInput');
            const leaveTypeText = document.getElementById('leaveTypeText');
            const leaveTypeSelector = document.getElementById('leaveTypeSelector');
            const startDateInput = document.getElementById('startDateInput');
            const startDateText = document.getElementById('startDateText');
            const startDateCalendar = document.getElementById('startDateCalendar');
            const endDateInput = document.getElementById('endDateInput');
            const endDateText = document.getElementById('endDateText');
            const endDateCalendar = document.getElementById('endDateCalendar');
            const numberOfDaysInput = document.getElementById('numberOfDays');
            const reasonInput = document.getElementById('reason');
            const handoverNotesInput = document.getElementById('handoverNotes');
            const fileNameSpan = document.getElementById('fileName');
            const fileUploadInput = document.getElementById('file-upload');
            const confirmCheckbox = document.getElementById('confirm-checkbox');
            const confirmError = document.getElementById('confirm-error');

            const successModal = document.getElementById('success-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            
            // --- Data and State ---
            const leaveTypes = ['Casual Leave', 'Sick Leave', 'Annual Leave', 'Maternity Leave', 'Paternity Leave'];
            let currentStep = 1;
            let formData = {
                leaveType: '',
                startDate: null,
                endDate: null,
                numberOfDays: 0,
                reason: '',
                handoverNotes: '',
                attachment: null,
            };

            // --- Helper Functions ---

            // Inject leave type buttons
            leaveTypes.forEach(type => {
                const button = document.createElement('button');
                button.textContent = type;
                button.type = 'button';
                button.className = `w-full text-left p-2 rounded-lg transition-colors duration-200 mb-1 text-gray-200 hover:bg-gray-700`;
                button.addEventListener('click', () => {
                    formData.leaveType = type;
                    leaveTypeText.textContent = type;
                    leaveTypeSelector.classList.add('hidden');
                    updateLeaveTypeButtons();
                });
                leaveTypeSelector.appendChild(button);
            });

            function updateLeaveTypeButtons() {
                Array.from(leaveTypeSelector.children).forEach(button => {
                    if (button.textContent === formData.leaveType) {
                        button.classList.add('bg-yellow-500', 'text-white');
                        button.classList.remove('hover:bg-gray-700', 'text-gray-200');
                    } else {
                        button.classList.remove('bg-yellow-500', 'text-white');
                        button.classList.add('hover:bg-gray-700', 'text-gray-200');
                    }
                });
            }

            function calculateWorkingDays() {
                if (!formData.startDate || !formData.endDate) {
                    formData.numberOfDays = 0;
                    numberOfDaysInput.value = 0;
                    return;
                }
                
                let start = new Date(formData.startDate.getFullYear(), formData.startDate.getMonth(), formData.startDate.getDate());
                const end = new Date(formData.endDate.getFullYear(), formData.endDate.getMonth(), formData.endDate.getDate());
                let workingDays = 0;
                
                if (start > end) {
                    formData.numberOfDays = 0;
                    numberOfDaysInput.value = 0;
                    return;
                }
                
                while (start <= end) {
                    const dayOfWeek = start.getDay();
                    if (dayOfWeek !== 0 && dayOfWeek !== 6) { // 0 = Sunday, 6 = Saturday
                        workingDays++;
                    }
                    start.setDate(start.getDate() + 1);
                }
                
                formData.numberOfDays = workingDays;
                numberOfDaysInput.value = workingDays;
            }
            
            function renderCalendar(targetElement, selectedDate, setDateCallback, initialMonth = new Date()) {
                let viewDate = new Date(initialMonth.getFullYear(), initialMonth.getMonth(), 1);
                
                function generateCalendarContent(date) {
                    const totalDays = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
                    const firstDayIndex = date.getDay();
                    
                    let calendarHTML = `
                        <div class="calendar-header">
                            <button type="button" class="calendar-nav-btn prev-month-btn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="font-bold text-sm text-white">
                                ${date.toLocaleString('default', { month: 'long', year: 'numeric' })}
                            </span>
                            <button type="button" class="calendar-nav-btn next-month-btn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="calendar-grid text-center text-xs">
                            <div class="calendar-day-label">Sun</div><div class="calendar-day-label">Mon</div><div class="calendar-day-label">Tue</div><div class="calendar-day-label">Wed</div><div class="calendar-day-label">Thu</div><div class="calendar-day-label">Fri</div><div class="calendar-day-label">Sat</div>
                        </div>
                        <div class="calendar-grid mt-1">
                    `;
    
                    for (let i = 0; i < firstDayIndex; i++) {
                        calendarHTML += `<div class="text-gray-600"></div>`;
                    }
    
                    for (let i = 1; i <= totalDays; i++) {
                        const dayDate = new Date(date.getFullYear(), date.getMonth(), i);
                        const isSelected = selectedDate && dayDate.toDateString() === selectedDate.toDateString();
                        const buttonClasses = `calendar-day ${isSelected ? 'active-day' : ''}`;
                        calendarHTML += `<button type="button" class="${buttonClasses}" data-day="${i}">${i}</button>`;
                    }
    
                    calendarHTML += `</div>`;
                    targetElement.innerHTML = calendarHTML;

                    targetElement.querySelector('.prev-month-btn').addEventListener('click', () => {
                        viewDate.setMonth(viewDate.getMonth() - 1);
                        generateCalendarContent(viewDate);
                    });
                    targetElement.querySelector('.next-month-btn').addEventListener('click', () => {
                        viewDate.setMonth(viewDate.getMonth() + 1);
                        generateCalendarContent(viewDate);
                    });
    
                    targetElement.querySelectorAll('.calendar-day').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            const day = parseInt(e.target.dataset.day);
                            const selectedDay = new Date(viewDate.getFullYear(), viewDate.getMonth(), day);
                            setDateCallback(selectedDay);
                            targetElement.classList.add('hidden');
                        });
                    });
                }

                generateCalendarContent(viewDate);
            }

            // --- Step Navigation and Rendering ---
            function navigateToStep(step) {
                // Hide all panels
                step1Panel.classList.add('hidden');
                step2Panel.classList.add('hidden');
                step3Panel.classList.add('hidden');

                // Reset step indicators
                document.querySelectorAll('.step-indicator-item').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('[id^="step-line-"]').forEach(el => el.classList.replace('bg-yellow-500', 'bg-gray-700'));

                const step1Ind = document.getElementById('step-1-indicator');
                const step2Ind = document.getElementById('step-2-indicator');
                const step3Ind = document.getElementById('step-3-indicator');
                const stepLine1 = document.getElementById('step-line-1');
                const stepLine2 = document.getElementById('step-line-2');
                
                // Update UI based on the new step
                if (step === 1) {
                    step1Panel.classList.remove('hidden');
                    step1Ind.classList.add('active');
                    formTitle.textContent = "Apply for Leave";
                    formDescription.textContent = "Please provide your basic leave details.";
                } else if (step === 2) {
                    step2Panel.classList.remove('hidden');
                    step1Ind.classList.add('active');
                    stepLine1.classList.replace('bg-gray-700', 'bg-yellow-500');
                    step2Ind.classList.add('active');
                    formTitle.textContent = "Purpose & Handover";
                    formDescription.textContent = "Tell us a bit more about your leave.";
                } else if (step === 3) {
                    step3Panel.classList.remove('hidden');
                    step1Ind.classList.add('active');
                    stepLine1.classList.replace('bg-gray-700', 'bg-yellow-500');
                    step2Ind.classList.add('active');
                    stepLine2.classList.replace('bg-gray-700', 'bg-yellow-500');
                    step3Ind.classList.add('active');
                    formTitle.textContent = "Final Review";
                    formDescription.textContent = "Please review your application before submitting.";
                    populateReviewPanel();
                }
                currentStep = step;
            }

            function populateReviewPanel() {
                document.getElementById('review-leaveType').textContent = formData.leaveType || 'Not specified';
                const startDateStr = formData.startDate ? formData.startDate.toLocaleDateString('en-GB') : 'Not specified';
                const endDateStr = formData.endDate ? formData.endDate.toLocaleDateString('en-GB') : 'Not specified';
                document.getElementById('review-dates').textContent = `${startDateStr} - ${endDateStr}`;
                document.getElementById('review-numberOfDays').textContent = `${formData.numberOfDays} Day(s)`;
                document.getElementById('review-reason').textContent = reasonInput.value || 'Not specified';
                document.getElementById('review-handoverNotes').textContent = handoverNotesInput.value || 'None';
                document.getElementById('review-attachment').textContent = formData.attachment ? formData.attachment.name : 'No file attached';
                
                confirmCheckbox.checked = false;
                toggleSubmitButton();
            }

            function toggleSubmitButton() {
                if (confirmCheckbox.checked) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // --- Event Listeners ---
            nextStep1Btn.addEventListener('click', () => {
                if (!formData.leaveType || !formData.startDate || !formData.endDate) {
                    alert('Please fill in all required fields.');
                    return;
                }
                navigateToStep(2);
            });

            prevStep2Btn.addEventListener('click', () => navigateToStep(1));
            nextStep2Btn.addEventListener('click', () => {
                formData.reason = reasonInput.value;
                formData.handoverNotes = handoverNotesInput.value;
                navigateToStep(3);
            });
            
            prevStep3Btn.addEventListener('click', () => navigateToStep(2));
            confirmCheckbox.addEventListener('change', toggleSubmitButton);
            
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', (e) => navigateToStep(parseInt(e.target.dataset.targetStep)));
            });

            leaveTypeInput.addEventListener('click', (e) => {
                e.stopPropagation();
                leaveTypeSelector.classList.toggle('hidden');
                startDateCalendar.classList.add('hidden');
                endDateCalendar.classList.add('hidden');
            });

            startDateInput.addEventListener('click', (e) => {
                e.stopPropagation();
                startDateCalendar.classList.toggle('hidden');
                endDateCalendar.classList.add('hidden');
                leaveTypeSelector.classList.add('hidden');
                renderCalendar(startDateCalendar, formData.startDate, (date) => {
                    formData.startDate = date;
                    startDateText.textContent = date.toLocaleDateString('en-GB');
                    calculateWorkingDays();
                });
            });

            endDateInput.addEventListener('click', (e) => {
                e.stopPropagation();
                endDateCalendar.classList.toggle('hidden');
                startDateCalendar.classList.add('hidden');
                leaveTypeSelector.classList.add('hidden');
                renderCalendar(endDateCalendar, formData.endDate, (date) => {
                    formData.endDate = date;
                    endDateText.textContent = date.toLocaleDateString('en-GB');
                    calculateWorkingDays();
                });
            });

            document.addEventListener('click', (e) => {
                if (!startDateCalendar.contains(e.target) && !startDateInput.contains(e.target)) {
                    startDateCalendar.classList.add('hidden');
                }
                if (!endDateCalendar.contains(e.target) && !endDateInput.contains(e.target)) {
                    endDateCalendar.classList.add('hidden');
                }
                if (!leaveTypeSelector.contains(e.target) && !leaveTypeInput.contains(e.target)) {
                    leaveTypeSelector.classList.add('hidden');
                }
            });

            fileUploadInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    formData.attachment = file;
                    fileNameSpan.textContent = file.name;
                } else {
                    formData.attachment = null;
                    fileNameSpan.textContent = 'Choose a file';
                }
            });
            
            closeModalBtn.addEventListener('click', () => successModal.classList.add('hidden'));

            leaveForm.addEventListener('submit', (e) => {
                e.preventDefault();
                if (!confirmCheckbox.checked) {
                    confirmError.classList.remove('hidden');
                    return;
                }
                confirmError.classList.add('hidden');
                console.log('Submitting form data:', formData);
                successModal.classList.remove('hidden');
            });

            navigateToStep(1);
        });
    </script>
</body>
</html>