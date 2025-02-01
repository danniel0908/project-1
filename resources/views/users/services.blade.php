@extends('users.layout')

@section('content')
<style>

.sidebar-content {
    padding-right: 70px;
}
    /* Responsive and Enhanced Services Table Styles */
.services-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 15px; /* Increased spacing between rows */
    margin-bottom: 20px;
}

.services-table tr {
    transition: all 0.3s ease;
}

.services-table tr:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.services-table td {
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-size: 16px;
    position: relative;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.services-table td a {
    display: flex;
    align-items: center;
    color: #333;
    text-decoration: none;
    font-weight: 600;
}

.services-table td a i {
    margin-right: 10px;
    color: #014716;
}

.info-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    font-size: 20px;
    transition: color 0.3s ease;
}

.info-btn:hover {
    color: #007bff;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-dialog {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    position: relative;
}

.modal-content {
    position: relative;
}

.modal-header {
    padding: 10px 15px;
    background-color: #f1f1f1;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

.modal-body {
    padding: 15px;
}
/* Enhanced Mobile Responsiveness */
@media screen and (max-width: 768px) {
    .services-table {
        border-spacing: 0 10px;
    }

    .services-table tr {
        display: block;
        margin-bottom: 15px;
    }

    .services-table td {
        display: block;
        width: 100%;
        text-align: left;
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        position: relative;
    }

    .services-table td a {
        flex-direction: column;
        align-items: flex-start;
    }

    .services-table td a i {
        margin-bottom: 5px;
        align-self: flex-start;
    }

    .info-btn {
        top: 15px;
        right: 15px;
        font-size: 18px;
    }

    /* Ensure full-width and proper spacing */
    .dashboard-container {
        padding: 15px;
    }

    .header-1 {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-1 h1 {
        margin-bottom: 10px;
    }

    .secondary-dashboard {
        margin-top: 5px;
    }
}

/* Accessibility and Focus States */
.services-table td:focus-within,
.services-table td:hover {
    outline: 2px solid #28a745; /* Green color */
    outline-offset: -2px;
}
/* Modal Improvements */
.modal-dialog {
    max-width: 95%;
    margin: 1.75rem auto;
}

.modal-content {
    border-radius: 10px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 15px;
}

.modal-body {
    padding: 20px;
}
</style>



<div class="dashboard-body" id="dashboardBody">
    <div class="dashboard-container">
        <header class="header-1">
            <div class="main-dashboard">
                <h1>Services Offered</h1>
            </div>
            <div class="secondary-dashboard">
                Services
                <a href="#">/Dashboard</a>
            </div>
        </header>
        
        <section class="content">
            <div class="Services">
                <table class="services-table">
                    <tbody>
                        <tr>
                            <td data-label="Application Permit">
                                <a href="{{ route('toda.fillup') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> TODA Application</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#todaApplicationModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                            <td data-label="Dropping">
                                <a href="{{ route('toda.drop.fillup') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> TODA Dropping</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#todaDroppingModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Application Permit">
                                <a href="{{ route('poda.fillup') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> PODA Application</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#podaApplicationModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                            <td data-label="Dropping">
                                <a href="{{ route('poda.drop.fillup') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> PODA Dropping</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#podaDroppingModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Application Permit" colspan="1">
                                <a href="{{ route('service-applications.create') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> Private Service Application</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#privateServiceModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Application Permit" colspan="1">
                                <a href="{{ route('ppf.fillup') }}" style="color: black; text-decoration: none;">
                                    <p class="label"><i class="fa-solid fa-pen-to-square"></i> Sticker Application (PUJ/PUV/PUB)</p>
                                </a>
                                <button class="info-btn" data-toggle="modal" data-target="#stickerApplicationModal">
                                    <i class="fa-solid fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        @include('users.footer')
    </div>
</div>

<!-- Modals for Service Information -->
<div class="modal fade" id="todaApplicationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TODA Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This service involves issuance, by the city government, of a franchise to a qualified
operator applying for a permit to operate a tricycle unit for hire within a designated
route and area in the territorial jurisdiction of the City of San Pedro, both for new
franchises and renewed franchises, provided that they meet the qualifications and
requirements as stipulated in City Ordinance No. 2017-23, otherwise known as the "2017 Traffic Ordinance of the City of San Pedro, Laguna".</p>
                <h6>Requirements:</h6>
                <ul>
                    <li>Duly-accomplished Application form (1 Original Set)</li>
                    <li>Inspection Clearance and/or Certificate of Noise Emission Compliance (1 Original Copy)</li>
                    <li>Latest Certificate of Registration and Official Receipt of the vehicle (1 Photocopy)</li>
                    <li>Deed of Sale or Deed of Conveyance/Transfer (1 Photocopy)</li>
                    <li>Insurance Coverage for Third Party Liability (1 Photocopy)</li>
                    <li>Barangay Business Clearance certifying availability of a garage (1 Original Copy)</li>
                    <li>2 x 2 I.D. pictures wearing TODA uniform (2 Original Copies)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li>
                </ul>
                <p>For Renewal of franchise</p>
                <ul>
                    <li>All requirements previously listed</li>
                    <li>Previous franchise or its official receipt (1 Photocopy)</li>

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="todaDroppingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TODA Dropping Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This service involves processing of petition, filed by a franchisee, to drop, terminate or relinquish his/her franchise.</p>
                <h6>Requirements:</h6>
                <ul>
                    <li>Petition for Dropping of Franchise form (1 Original Set)</li>
                    <li>Current franchise (1 Original Copy)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li> 
                </ul>
                <p>Requires approval from the association board and submission of necessary documentation.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="podaApplicationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PODA Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This service involves issuance, by the city government, of a franchise to a qualified operator applying for a permit to operate a pedicab unit for hire within a designated route and area in the territorial jurisdiction of the City of San Pedro.</p>
                <h6>Requirements:</h6>
                <ul>
                    <li>Duly-accomplished Application form (1 Original Set)</li>
                    <li>Inspection Clearance (1 Original Copy)</li>
                    <li>Insurance Coverage for Third Party Liability (1 Photocopy)</li>
                    <li>Barangay Business Clearance certifying availability of a garage (1 Original Copy)</li>
                    <li>2 x 2 I.D. pictures wearing PODA uniform (2 Original Copies)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li>
                </ul>
                <p>For Renewal of franchise</p>
                <ul>
                    <li>All requirements previously listed</li>
                    <li>Previous franchise or its official receipt (1 Photocopy)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="podaDroppingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PODA Dropping Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p>This service involves processing of petition, filed by a franchisee, to drop, terminate or relinquish his/her franchise.</p>
                <h6>Requirements:</h6>
                <ul>
                    <li>Petition for Dropping of Franchise form (1 Original Set)</li>
                    <li>Current franchise (1 Original Copy)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li> 
                </ul>
                <p>Requires approval from the association board and submission of necessary documentation.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="privateServiceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Private Service Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This service involves issuance, by the city government, of a franchise to a qualified operator applying for a permit to operate a tricycle unit for private use or for service within the territorial jurisdiction of the City of San Pedro</p>
                <h6>Requirements</h6>
                <ul>
                    <li>Duly-accomplished Application form (1 Original Set)</li>
                    <li>Inspection Clearance and/or Certificate of Noise Emission Compliance (1 Original Copy)</li>
                    <li>Latest Certificate of Registration and Official Receipt of the vehicle (1 Photocopy)</li>
                    <li>Deed of Sale or Deed of Conveyance/Transfer (1 Photocopy)</li>
                    <li>Insurance Coverage for Third Party Liability (1 Photocopy)</li>
                    <li>Barangay Business Clearance certifying availability of a garage (1 Original Copy)</li>
                    <li>2 x 2 I.D. pictures wearing TODA uniform (2 Original Copies)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li>
                </ul>
                <p>For Renewal of franchise</p>
                <ul>
                    <li>All requirements previously listed</li>
                    <li>Previous franchise or its official receipt (1 Photocopy)</li>
                </ul>

                <p>For school service</p>
                <ul>
                    <li>All requirements previously listed</li>
                    <li>School Permit (1 Photocopy)</li>
                </ul>
                <p>For school service</p>
                <ul>
                    <li>All requirements previously listed</li>
                    <li>Business Permit (1 Photocopy)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stickerApplicationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sticker Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This service involves issuance, by the city government, of City Sticker to Public Utility Jeepney, Bus, Van and other similar vehicle for hire with a fixed and authorized terminal located in the territorial jurisdiction of the City of San Pedro.</p>
                <h6>Requirements</h6>
                <ul>
                    <li>Duly-accomplished Application form (1 Original Set)</li>
                    <li>Certificate of Noise Emission Compliance (1 Original Copy)</li>
                    <li>Latest Certificate of Registration and Official Receipt of the vehicle (1 Photocopy)</li>
                    <li>Barangay Business Clearance certifying availability of a garage (1 Original Copy)</li>
                    <li>2 x 2 I.D. pictures (2 Original Copies)</li>
                    <li>Official Receipt (1 Original Copy and 1 Photocopy)</li>
                    <li>Current Franchise (1 Photocopy)</li>
                </ul>
                <p>Stickers validate vehicle's compliance with transportation regulations.</p>
            </div>
        </div>
    </div>
</div>

@endsection



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to open modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Function to close modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Attach event listeners to info buttons
    document.querySelectorAll('.info-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetModalId = this.getAttribute('data-target').replace('#', '');
            openModal(targetModalId);
        });
    });

    // Attach event listeners to close buttons
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modalId = this.closest('.modal').id;
            closeModal(modalId);
        });
    });

    // Close modal if clicked outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
});
</script>