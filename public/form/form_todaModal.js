// Constants
const TODA_OPTIONS = [
    "ACRHOTODA", "AMPCHOSJTODA", "BCTODA", "CVTODA", "DHAPATTODA",
    "LAFITTODA", "PACTODA", "PCHAITODA", "PIGGERYTODA", "RJCTODA",
    "RUNSTODA", "SASTODA", "SAWESTVTODA", "SEPAGCOTODA", "SKLTODA",
    "SPVHTODA", "SPDOTA", "SRCOTODA", "STLTPDA", "SCSPTODA"
];

// Initialize form on load
document.addEventListener('DOMContentLoaded', () => {
    initializeForm();
    setupEventListeners();
    populateTodaAssociations();
});

function initializeForm() {
    const applicantType = document.getElementById('applicantType').value.toLowerCase();
    updateFormForApplicantType(applicantType);
    fillUserCredentials(applicantType);
}

function updateFormForApplicantType(applicantType) {
    const applicantFields = document.getElementById('applicantFields');
    const driverFields = document.getElementById('driverFields');
    const autoFillCheckbox = document.getElementById('autoFillDriverFields');

    // Always show both fields
    applicantFields.style.display = 'block';
    driverFields.style.display = 'block';

    // Remove the visibility condition - checkbox should always be visible
    if (autoFillCheckbox) {
        autoFillCheckbox.style.display = 'inline-block';
    }
}

function fillUserCredentials(applicantType) {
    const userInfo = {
        firstName: document.getElementById('userFirstName')?.value,
        middleName: document.getElementById('userMiddleName')?.value,
        lastName: document.getElementById('userLastName')?.value,
        suffix: document.getElementById('userSuffix')?.value,
        contactNo: document.getElementById('userContactNo')?.value,
        address: document.getElementById('userAddress')?.value
    };

    if (applicantType === 'operator') {
        document.getElementById('applicant_first_name').value = userInfo.firstName || '';
        document.getElementById('applicant_middle_name').value = userInfo.middleName || '';
        document.getElementById('applicant_last_name').value = userInfo.lastName || '';
        document.getElementById('applicant_suffix').value = userInfo.suffix || '';
        document.getElementById('Contact_No_1').value = userInfo.contactNo || '';
        document.getElementById('Address1').value = userInfo.address || '';
    } else if (applicantType === 'driver') {
        document.getElementById('driver_first_name').value = userInfo.firstName || '';
        document.getElementById('driver_middle_name').value = userInfo.middleName || '';
        document.getElementById('driver_last_name').value = userInfo.lastName || '';
        document.getElementById('driver_suffix').value = userInfo.suffix || '';
        document.getElementById('Contact_No_2').value = userInfo.contactNo || '';
        document.getElementById('Address_2').value = userInfo.address || '';
    }
}

function handleAutoFillDriver(event) {
    const isChecked = event.target.checked;
    const applicantType = document.getElementById('applicantType').value.toLowerCase();
    
    // Define field mappings based on applicant type
    const fieldMappings = applicantType === 'operator' ? {
        // If operator, copy from applicant to driver fields
        'applicant_first_name': 'driver_first_name',
        'applicant_middle_name': 'driver_middle_name',
        'applicant_last_name': 'driver_last_name',
        'applicant_suffix': 'driver_suffix',
        'Contact_No_1': 'Contact_No_2',
        'Address1': 'Address_2'
    } : {
        // If driver, copy from driver to applicant fields
        'driver_first_name': 'applicant_first_name',
        'driver_middle_name': 'applicant_middle_name',
        'driver_last_name': 'applicant_last_name',
        'driver_suffix': 'applicant_suffix',
        'Contact_No_2': 'Contact_No_1',
        'Address_2': 'Address1'
    };

    if (isChecked) {
        // Copy values from source to target fields
        Object.entries(fieldMappings).forEach(([fromField, toField]) => {
            const fromElement = document.getElementById(fromField);
            const toElement = document.getElementById(toField);
            if (fromElement && toElement) {
                toElement.value = fromElement.value;
                toElement.readOnly = true;
                
                // Add input event listener to source fields
                fromElement.addEventListener('input', function() {
                    if (document.getElementById('autoFillDriverFields').checked) {
                        toElement.value = fromElement.value;
                    }
                });
            }
        });
    } else {
        // Make target fields editable again
        Object.values(fieldMappings).forEach(fieldId => {
            const element = document.getElementById(fieldId);
            if (element) {
                element.readOnly = false;
                element.value = ''; // Clear the value when unchecked
            }
        });
    }
}


function setupEventListeners() {
    // Set up auto-fill checkbox listener
    const autoFillCheckbox = document.getElementById('autoFillDriverFields');
    if (autoFillCheckbox) {
        autoFillCheckbox.addEventListener('change', handleAutoFillDriver);
    }

    // Add contact number formatting
    const contactFields = ['Contact_No_1', 'Contact_No_2'];
    contactFields.forEach(fieldId => {
        const element = document.getElementById(fieldId);
        if (element) {
            element.addEventListener('input', () => formatContactNumber(element));
        }
    });

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', validateForm);
    }
}

function validateForm(event) {
    let isValid = true;
    const applicantType = document.getElementById('applicantType').value.toLowerCase();
    
    const requiredFields = [
        'todaAssociationSelect',
        'driver_first_name',
        'driver_last_name',
        'Contact_No_2',
        'Address_2',
        'Body_no',
        'Plate_no',
        'Make',
        'Engine_no',
        'Chassis_no'
    ];

    if (applicantType === 'operator') {
        requiredFields.push(
            'applicant_first_name',
            'applicant_last_name',
            'Contact_No_1',
            'Address1'
        );
    }

    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field && !field.value.trim()) {
            field.style.borderColor = 'red';
            isValid = false;
        } else if (field) {
            field.style.borderColor = '';
        }
    });

    if (!isValid) {
        event.preventDefault();
        alert('Please fill in all required fields.');
    }
}

function populateTodaAssociations() {
    const selectElement = document.getElementById("todaAssociationSelect");
    if (!selectElement) return;

    selectElement.innerHTML = '';

    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select TODA Association";
    selectElement.appendChild(defaultOption);

    const currentValue = selectElement.dataset.currentValue || selectElement.value || '';

    TODA_OPTIONS.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        
        if (option === currentValue) {
            optionElement.selected = true;
        }
        
        selectElement.appendChild(optionElement);
    });
}

function formatContactNumber(input) {
    let number = input.value.replace(/\D/g, '');
    number = number.substring(0, 11);
    
    if (number.length > 6) {
        number = `${number.substring(0, 3)}-${number.substring(3, 6)}-${number.substring(6)}`;
    } else if (number.length > 3) {
        number = `${number.substring(0, 3)}-${number.substring(3)}`;
    }
    
    input.value = number;
}