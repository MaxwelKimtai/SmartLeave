<?php
session_start();
session_regenerate_id(true);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // ✅ Ensure employee is logged in (use dedicated keys)
    if (empty($_SESSION['employee_api_token']) || empty($_SESSION['employee_id'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Not logged in as employee']);
        exit();
    }

    // ✅ Validate CSRF token
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        http_response_code(419);
        echo json_encode(['message' => 'Invalid CSRF token']);
        exit();
    }

    // ✅ Extract token and employee ID
    $apiToken   = $_SESSION['employee_api_token'];
    $employeeId = $_SESSION['employee_id'];

    // ✅ Prepare payload for API
    $payload = [
        'employee_id'    => $employeeId, // stays tied to employee session
        'leave_type'     => $_POST['leave_type'] ?? null,
        'start_date'     => $_POST['start_date'] ?? null,
        'end_date'       => $_POST['end_date'] ?? null,
        'number_of_days' => $_POST['number_of_days'] ?? null,
        'reason'         => $_POST['reason'] ?? null,
        'handover_notes' => $_POST['handover_notes'] ?? null
    ];

    // ✅ Handle file upload if present
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['attachment'];
        $payload['attachment'] = new CURLFile(
            $file['tmp_name'],
            mime_content_type($file['tmp_name']),
            $file['name']
        );
    }

    // ✅ Call Laravel API
    $apiUrl = 'http://127.0.0.1:8000/api/leave_requests';
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Authorization: Bearer ' . $apiToken,
        ],
        CURLOPT_POSTFIELDS     => $payload,
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        http_response_code(500);
        echo json_encode(['message' => 'cURL error: ' . curl_error($ch)]);
        exit();
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // ✅ Forward Laravel response
    http_response_code($statusCode);
    echo $response;
    exit();
}
?>

<!-- CSRF token for JS -->
<script>
window.csrfToken = '<?php echo $_SESSION['csrf_token']; ?>';
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Import Google Fonts - Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap');
        
        /* Disable scrolling and set global font and background */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* This disables scrolling for the entire page */
            font-family: 'Inter', sans-serif;
            color: #000000; /* Set default font color to black */
        }
        
        body {
            background-color: #1a202c; /* Default dark background */
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-position: center;
        }

        .glassmorphism-card {
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
        }

        /* Full-screen card style */
        .full-screen-card {
            width: 100%;
            height: 100%;
            max-width: none;
            border-radius: 0;
            border: none;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Aligns content to the top of the card */
            padding: 2rem; /* Add generous padding around the card content */
            box-sizing: border-box; /* Ensures padding is included in the height */
            overflow-y: auto; /* Allows internal scrolling if content overflows */
        }

        .transition-all {
            transition-property: all;
            transition-duration: 300ms;
        }
        
        /* Form input styles with black text */
        .form-input {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.75rem;
            padding: 0.8rem 1rem; /* Slightly reduced padding for a more compact look */
            color: #000000; /* Set input text color to black */
            transition: all 0.3s;
        }
        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #FFC107; /* Yellow focus ring */
            border-color: #FFC107;
        }
        .form-input::placeholder {
            color: #333333; /* Darker placeholder text for contrast */
        }

        /* Leave type selector styles */
        .leave-type-selector {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 0.5rem;
            padding: 1rem;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.2);
            width: 100%;
            z-index: 50;
        }
        .leave-type-button {
            text-align: left;
            padding: 0.75rem;
            border-radius: 0.5rem;
            color: #000000;
            transition-colors: 0.2s;
            cursor: pointer;
        }
        .leave-type-button:hover {
            background-color: #FFEB3B; /* Lighter yellow on hover */
        }
        .leave-type-button.active {
            background-color: #FFC107;
            font-weight: bold;
        }
        
        /* Calendar container styles */
        .calendar-container {
            position: absolute;
            z-index: 50;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.2);
        }
        .calendar-nav-btn {
            color: #000000;
        }
        .calendar-nav-btn:hover {
            color: #FFC107;
        }
        .calendar-day-label {
            color: #666666;
        }
        .calendar-day-button {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
            color: #000000;
        }
        .calendar-day-button:not(.active-day):hover {
            background-color: #FFEB3B;
        }
        .calendar-day-button.active-day {
            background-color: #FFC107;
            font-weight: bold;
        }
        .calendar-day-button.inactive {
            color: rgba(0, 0, 0, 0.2);
            cursor: not-allowed;
        }
        
        /* Stepper styles with yellow */
        .step-indicator-item div {
            background-color: #e5e7eb;
            color: #6b7280;
        }
        .step-indicator-item.active div {
            background-color: #FFC107; /* Yellow for active step circle */
            color: #000000; /* Black text for active step */
        }
        .step-indicator-item.active span {
            color: #000000; /* Black text for active step label */
        }
        #step-line-1, #step-line-2 {
            background-color: #e5e7eb;
        }
        .step-indicator-item.active + #step-line-1,
        .step-indicator-item.active + #step-line-2 {
            background-color: #FFC107; /* Yellow line for active step */
        }
        
        /* Major buttons styling */
        .button-primary {
            background-color: #FFC107;
            color: #000000;
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 9999px; /* Tailwind's rounded-full */
            transition: all 0.2s;
        }
        .button-primary:hover {
            background-color: #FFEB3B;
        }
        .button-secondary {
            background-color: #e5e7eb;
            color: #000000;
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.2s;
        }
        .button-secondary:hover {
            background-color: #d1d5db;
        }
       .flex.justify-between.items-center.mb-8 {
            margin-top: 1.5rem; /* Moves stepper down from top, adjust to taste */
            margin-bottom: 1.5rem; /* Creates good space below stepper */
}
    </style>
</head>
<body class="p-0">
    <div id="form-container" class="w-full mx-auto glassmorphism-card p-6 md:p-8 rounded-2xl shadow-2xl border border-gray-700 full-screen-card">
        
        <div class="flex justify-between items-center mb-8">
            <div id="step-1-indicator" class="flex flex-col items-center space-y-2 step-indicator-item active">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300">
                    1
                </div>
                <span class="text-xs md:text-sm font-medium transition-colors duration-300">
                    Basic Info
                </span>
            </div>
            <div id="step-line-1" class="flex-1 h-1 mx-2 transition-colors duration-300"></div>
            <div id="step-2-indicator" class="flex flex-col items-center space-y-2 step-indicator-item">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300">
                    2
                </div>
                <span class="text-xs md:text-sm font-medium transition-colors duration-300">
                    Purpose & Handover
                </span>
            </div>
            <div id="step-line-2" class="flex-1 h-1 mx-2 transition-colors duration-300"></div>
            <div id="step-3-indicator" class="flex flex-col items-center space-y-2 step-indicator-item">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300">
                    3
                </div>
                <span class="text-xs md:text-sm font-medium transition-colors duration-300">
                    Review & Submit
                </span>
            </div>
        </div>

        <h1 id="form-title" class="text-3xl md:text-4xl font-extrabold mb-2">Apply for Leave</h1>
        <p id="form-description" class="mb-8">
            Please provide your basic leave details.
        </p>

        <form id="leave-form" novalidate>
            <div id="step-1-panel" class="space-y-6">
                <div class="relative">
                    <label for="leaveType" class="block font-medium mb-2">Leave Type</label>
                    <div id="leaveTypeInput" class="form-input flex items-center justify-between cursor-pointer hover:bg-opacity-80 transition-colors">
                        <span id="leaveTypeText">Choose a leave type</span>
                        <i class="fas fa-chevron-right text-black"></i>
                    </div>
                    <div id="leaveTypeSelector" class="leave-type-selector hidden">
                        </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label for="startDate" class="block font-medium mb-2">Start Date</label>
                        <div id="startDateInput" class="form-input flex items-center justify-between cursor-pointer hover:bg-opacity-80 transition-colors">
                            <span id="startDateText">dd/mm/yyyy</span>
                            <i class="far fa-calendar-alt text-lg text-black"></i>
                        </div>
                        <div id="startDateCalendar" class="calendar-container hidden"></div>
                    </div>
                    <div class="relative">
                        <label for="endDate" class="block font-medium mb-2">End Date</label>
                        <div id="endDateInput" class="form-input flex items-center justify-between cursor-pointer hover:bg-opacity-80 transition-colors">
                            <span id="endDateText">dd/mm/yyyy</span>
                            <i class="far fa-calendar-alt text-lg text-black"></i>
                        </div>
                        <div id="endDateCalendar" class="calendar-container hidden"></div>
                    </div>
                </div>
                <div>
                    <label for="numberOfDays" class="block font-medium mb-2">Number of Days</label>
                    <input type="text" id="numberOfDays" name="numberOfDays" class="form-input cursor-not-allowed" value="0" readonly />
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="button" id="next-step-1-btn" class="button-primary">
                        Next
                    </button>
                </div>
            </div>

            <div id="step-2-panel" class="hidden space-y-6">
                <div>
                    <label for="reason" class="block font-medium mb-2">Reason for Leave</label>
                    <textarea id="reason" name="reason" rows="3" class="form-input" placeholder="Enter a brief reason for your leave"></textarea>
                </div>
                <div>
                    <label for="handoverNotes" class="block font-medium mb-2">Handover Notes <span class="text-xs italic">(optional)</span></label>
                    <textarea id="handoverNotes" name="handoverNotes" rows="3" class="form-input" placeholder="Who will cover your tasks or what needs to be done?"></textarea>
                </div>
                <div>
                    <label for="attachment" class="block font-medium mb-2">Attachment <span class="text-xs italic">(single file upload)</span></label>
                    <label for="file-upload" class="form-input cursor-pointer flex items-center justify-between hover:bg-opacity-80 transition-colors">
                        <span id="fileName" class="truncate">Choose a file</span>
                        <i class="fas fa-cloud-upload-alt text-lg text-black"></i>
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
                <div class="space-y-4">
                    <h3 class="text-xl font-bold mb-4">Review your application</h3>
                    <div class="flex items-center justify-between py-2 border-b border-gray-300">
                        <p class="font-semibold">Leave Type</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-leaveType"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-300">
                        <p class="font-semibold">Dates</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-dates"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-300">
                        <p class="font-semibold">Number of Days</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-numberOfDays"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="1">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-start justify-between py-2 border-b border-gray-300">
                        <p class="font-semibold">Reason</p>
                        <div class="flex items-center space-x-2 text-right max-w-[60%]">
                            <span id="review-reason" class="text-sm"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="2">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-start justify-between py-2">
                        <p class="font-semibold">Handover Notes</p>
                        <div class="flex items-center space-x-2 text-right max-w-[60%]">
                            <span id="review-handoverNotes" class="text-sm"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="2">Edit</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-300">
                        <p class="font-semibold">Attachment</p>
                        <div class="flex items-center space-x-2">
                            <span id="review-attachment"></span>
                            <button type="button" class="edit-btn text-yellow-500 hover:text-yellow-600 text-sm" data-target-step="2">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="flex items-start mt-6">
                    <input type="checkbox" id="confirm-checkbox" name="confirm" class="mt-1 mr-2 w-4 h-4 text-yellow-500 bg-gray-200 border-gray-300 rounded focus:ring-yellow-500">
                    <label for="confirm-checkbox" class="text-sm">I confirm this information is accurate and I have a valid reason for my leave.</label>
                </div>
                <p id="confirm-error" class="text-red-500 text-sm mt-2 hidden">Please confirm the information is accurate.</p>

                <div class="mt-8 flex justify-between">
                    <button type="button" id="prev-step-3-btn" class="button-secondary">
                        Back
                    </button>
                    <button type="submit" id="submit-btn" class="button-primary opacity-50 cursor-not-allowed" disabled>
                        Submit Application
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center p-4 z-[999]">
        <div class="relative bg-white bg-opacity-30 backdrop-filter backdrop-blur-lg p-8 rounded-3xl shadow-2xl text-center border border-gray-300 max-w-md w-full">
            <button id="close-modal-btn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition-colors">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
            <i class="fas fa-check-circle text-green-500 text-6xl mx-auto mb-4"></i>
            <h2 class="text-2xl md:text-3xl font-bold mb-2">
                Application Submitted!
            </h2>
            <p class="text-lg">
                Your leave request has been sent successfully. Have a wonderful day! ✨
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
    let formData = {
        leaveType: '',
        startDate: null,
        endDate: null,
        numberOfDays: 0,
        reason: '',
        handoverNotes: '',
        attachment: null,
    };
    
    // --- Dummy Data (In a real app, this would come from an API) ---
    const publicHolidays = ['2025-12-25', '2025-01-01']; 
    const bookedLeaveDays = ['2025-10-10', '2025-10-11']; 

    // --- Helper & Utility Functions ---
    function formatDate(date) {
        if (!date) return 'dd/mm/yyyy';
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    function calculateWorkingDays(startDate, endDate) {
        if (!startDate || !endDate || startDate > endDate) {
            return 0;
        }
        let start = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        const end = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        let workingDays = 0;
        while (start <= end) {
            const dayOfWeek = start.getDay();
            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // 0 = Sunday, 6 = Saturday
                workingDays++;
            }
            start.setDate(start.getDate() + 1);
        }
        return workingDays;
    }

    // --- Step Navigation and Rendering ---
    function navigateToStep(step) {
        // Hide all panels
        step1Panel.classList.add('hidden');
        step2Panel.classList.add('hidden');
        step3Panel.classList.add('hidden');

        // Reset step indicators
        document.querySelectorAll('.step-indicator-item').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('[id^="step-line-"]').forEach(el => el.classList.remove('bg-yellow-500'));

        // Update UI based on the new step
        if (step === 1) {
            step1Panel.classList.remove('hidden');
            document.getElementById('step-1-indicator').classList.add('active');
            formTitle.textContent = "Apply for Leave";
            formDescription.textContent = "Please provide your basic leave details.";
        } else if (step === 2) {
            step2Panel.classList.remove('hidden');
            document.getElementById('step-1-indicator').classList.add('active');
            document.getElementById('step-line-1').classList.add('bg-yellow-500');
            document.getElementById('step-2-indicator').classList.add('active');
            formTitle.textContent = "Purpose & Handover";
            formDescription.textContent = "Tell us a bit more about your leave.";
        } else if (step === 3) {
            step3Panel.classList.remove('hidden');
            document.getElementById('step-1-indicator').classList.add('active');
            document.getElementById('step-line-1').classList.add('bg-yellow-500');
            document.getElementById('step-2-indicator').classList.add('active');
            document.getElementById('step-line-2').classList.add('bg-yellow-500');
            document.getElementById('step-3-indicator').classList.add('active');
            formTitle.textContent = "Final Review";
            formDescription.textContent = "Please review your application before submitting.";
            populateReviewPanel();
        }
    }

    function populateReviewPanel() {
    const days = calculateWorkingDays(formData.startDate, formData.endDate);
    formData.numberOfDays = days; // ✅ keep synced

    document.getElementById('review-leaveType').textContent = formData.leaveType || 'Not specified';
    document.getElementById('review-dates').textContent = `${formatDate(formData.startDate)} - ${formatDate(formData.endDate)}`;
    document.getElementById('review-numberOfDays').textContent = `${days} Day(s)`;
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
    
    // --- Calendar Logic ---
    function isWeekend(date) {
        const day = date.getDay();
        return day === 0 || day === 6;
    }

    function isPublicHoliday(date) {
        const publicHolidays = ['2025-12-25', '2025-01-01'];
        const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        return publicHolidays.includes(formattedDate);
    }

    function isAlreadyBooked(date) {
        const bookedLeaveDays = ['2025-10-10', '2025-10-11'];
        const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        return bookedLeaveDays.includes(formattedDate);
    }

    function renderCalendar(targetElement, selectedDate, setDateCallback) {
        let viewDate = selectedDate ? new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1) : new Date(new Date().getFullYear(), new Date().getMonth(), 1);

        function generateCalendarContent(date) {
            const totalDays = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
            const firstDayIndex = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let calendarHTML = `
                <div class="flex items-center justify-between mb-2">
                    <button type="button" class="calendar-nav-btn prev-month-btn" aria-label="Previous month">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="font-bold text-black text-sm">
                        ${date.toLocaleString('default', { month: 'long', year: 'numeric' })}
                    </span>
                    <button type="button" class="calendar-nav-btn next-month-btn" aria-label="Next month">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center text-xs">
                    <div class="calendar-day-label">Sun</div><div class="calendar-day-label">Mon</div><div class="calendar-day-label">Tue</div><div class="calendar-day-label">Wed</div><div class="calendar-day-label">Thu</div><div class="calendar-day-label">Fri</div><div class="calendar-day-label">Sat</div>
                </div>
                <div class="grid grid-cols-7 gap-1 mt-1">
                `;

            for (let i = 0; i < firstDayIndex; i++) {
                calendarHTML += `<div class="text-gray-400"></div>`;
            }

            for (let i = 1; i <= totalDays; i++) {
                const dayDate = new Date(date.getFullYear(), date.getMonth(), i);
                const isSelected = selectedDate && dayDate.toDateString() === selectedDate.toDateString();
                const isDisabled = dayDate < today || isWeekend(dayDate) || isPublicHoliday(dayDate) || isAlreadyBooked(dayDate);
                
                let buttonClasses = `calendar-day-button ${isSelected ? 'active-day' : ''}`;
                if (isDisabled) {
                    buttonClasses += ' disabled-day';
                }
                if (isWeekend(dayDate)) {
                    buttonClasses += ' weekend-day';
                }
                if (isPublicHoliday(dayDate)) {
                    buttonClasses += ' public-holiday-day';
                }
                if (isAlreadyBooked(dayDate)) {
                    buttonClasses += ' booked-day';
                }

                calendarHTML += `<button type="button" class="${buttonClasses}" data-day="${i}" ${isDisabled ? 'disabled' : ''} aria-label="Select ${dayDate.toDateString()}">${i}</button>`;
            }
            
            calendarHTML += `</div>`;
            targetElement.innerHTML = calendarHTML;

            // CORRECTED: BINDING THE EVENT LISTENERS INSIDE THE FUNCTION
            targetElement.querySelector('.prev-month-btn').addEventListener('click', () => {
                viewDate.setMonth(viewDate.getMonth() - 1);
                generateCalendarContent(viewDate);
            });
            targetElement.querySelector('.next-month-btn').addEventListener('click', () => {
                viewDate.setMonth(viewDate.getMonth() + 1);
                generateCalendarContent(viewDate);
            });

            targetElement.querySelectorAll('.calendar-day-button:not([disabled])').forEach(btn => {
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

    // --- Event Listeners ---
    leaveTypeInput.addEventListener('click', () => {
        leaveTypeSelector.classList.toggle('hidden');
    });

    leaveTypes.forEach(type => {
        const button = document.createElement('button');
        button.textContent = type;
        button.className = 'leave-type-button w-full mb-1';
        button.addEventListener('click', () => {
            formData.leaveType = type;
            leaveTypeText.textContent = type;
            leaveTypeSelector.classList.add('hidden');
        });
        leaveTypeSelector.appendChild(button);
    });

    startDateInput.addEventListener('click', () => {
        startDateCalendar.classList.toggle('hidden');
        // RE-RENDER CALENDAR EACH TIME
        if (!startDateCalendar.classList.contains('hidden')) {
            renderCalendar(startDateCalendar, formData.startDate, (date) => {
                formData.startDate = date;
                startDateText.textContent = formatDate(date);
                numberOfDaysInput.value = calculateWorkingDays(formData.startDate, formData.endDate);
            });
        }
    });

    // CORRECTED: ADD THE EVENT LISTENER FOR THE END DATE
    endDateInput.addEventListener('click', () => {
        endDateCalendar.classList.toggle('hidden');
        // RE-RENDER CALENDAR EACH TIME
        if (!endDateCalendar.classList.contains('hidden')) {
            renderCalendar(endDateCalendar, formData.endDate, (date) => {
                formData.endDate = date;
                endDateText.textContent = formatDate(date);
                numberOfDaysInput.value = calculateWorkingDays(formData.startDate, formData.endDate);
            });
        }
    });

    nextStep1Btn.addEventListener('click', () => {
        if (!formData.leaveType || !formData.startDate || !formData.endDate) {
            alert("Please select a leave type, start date, and end date.");
            return;
        }
        if (formData.startDate > formData.endDate) {
            alert("Start date cannot be after end date.");
            return;
        }
        navigateToStep(2);
    });

    prevStep2Btn.addEventListener('click', () => {
        navigateToStep(1);
    });

    nextStep2Btn.addEventListener('click', () => {
        if (!reasonInput.value) {
            alert("Please provide a reason for your leave.");
            return;
        }
        navigateToStep(3);
    });

    prevStep3Btn.addEventListener('click', () => {
        navigateToStep(2);
    });

    confirmCheckbox.addEventListener('change', toggleSubmitButton);
    
    fileUploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            fileNameSpan.textContent = file.name;
            formData.attachment = file;
        } else {
            fileNameSpan.textContent = 'Choose a file';
            formData.attachment = null;
        }
    });

leaveForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!confirmCheckbox.checked) {
        confirmError.classList.remove('hidden');
        return;
    }
    confirmError.classList.add('hidden');

    // 🔒 Require login
    const token = sessionStorage.getItem('api_token');
    if (!token) {
        alert("Please log in first.");
        window.location.href = "login.php";
        return;
    }

    // Add a loading state
    submitBtn.textContent = 'Submitting...';
    submitBtn.disabled = true;

    // Build payload with FormData (good for file upload)
    const payload = new FormData();
    payload.append('leave_type', formData.leaveType);
    payload.append('start_date', formData.startDate ? formData.startDate.toISOString().split('T')[0] : '');
    payload.append('end_date', formData.endDate ? formData.endDate.toISOString().split('T')[0] : '');
    payload.append('number_of_days', formData.numberOfDays);
    payload.append('reason', reasonInput.value);
    payload.append('handover_notes', handoverNotesInput.value || '');
    if (formData.attachment) {
        payload.append('attachment', formData.attachment);
    }

    try {
        const response = await fetch("http://127.0.0.1:8000/api/employee/leave_requests", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token
                // NOTE: do not set Content-Type here, fetch will auto-set for FormData
            },
            body: payload
        });

        if (!response.ok) {
            const errData = await response.json().catch(() => ({}));
            throw new Error(errData.message || `HTTP ${response.status}`);
        }

        const data = await response.json();
        console.log('Success:', data);

        // Show success modal
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');

        // Auto-redirect after 3 seconds
        const redirectTimeout = setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 3000);

        // Redirect immediately if user clicks "Close"
        closeModalBtn.addEventListener('click', () => {
            clearTimeout(redirectTimeout);
            window.location.href = "dashboard.php";
        }, { once: true });

    } catch (err) {
        console.error('Submission error:', err);
        alert('Could not send request: ' + err.message);
    } finally {
        submitBtn.textContent = 'Submit Application';
        toggleSubmitButton();
    }
});

})

    </script>
</body>
</html>