<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrollable Modal with Left-Aligned Translation Button</title>
    <style>
        /* Modal background - disable scrolling */
        body.modal-open {
            overflow: hidden;
        }

        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            display: none;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 450px;
            max-width: 90%;
            text-align: justify;
            border-radius: 8px;
            position: relative;
        }

        .button-container {
            position: sticky;
            bottom: 0;
            background-color: white;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .right-buttons {
            display: flex;
            gap: 10px;
        }

        button {
            padding: 5px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #45a049;
        }

        #exitButton {
            background-color: #f44336;
        }

        #exitButton:hover {
            background-color: #e53935;
        }

        #translateButton {
            background-color: #2196F3;
        }

        #translateButton:hover {
            background-color: #1E88E5;
        }
    </style>
</head>
<body>
    <!-- User Agreement Modal -->
    <div id="userAgreementModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Data Privacy Notice</h2>
            <div id="modalContent">
                <p>The PermiSo Website of POSO-TRU San Pedro is fully compliant with Republic Act No. 10173, otherwise known as the Data Privacy Act of 2012 by protecting and securing custody of personal data submitted through physical documents, digital mail or through our websites/portal.</p>
                <p>The information collected are protected as we implement stringent security measures by allowing only authorized access to limited authorized personnel to man our system and records containing sensitive information.</p>
                <p>For any other concerns regarding this Privacy Notice, you may contact our office Administrative at landline no. (049) 559-8350 local 500-503 or e-mail us at permiSo.posot.gov.ph.</p>
                <p>Be assured that we only share your information if required by the law, or if necessary for compliance associated with a non-disclosure agreement to keep and treat all of your information confidential.</p>
                <p>Please review the agreement carefully and click "Agree" to continue to the dashboard.</p>
            </div>

            <!-- Button container -->
            <div class="button-container">
                <button id="translateButton">Translate to Tagalog</button>
                <div class="right-buttons">
                    <button id="exitButton">Exit</button>
                    <button id="agreeButton">Agree</button>
                </div>
            </div>

            <!-- Hidden logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let userAgreed = localStorage.getItem('userAgreed');
            if (!userAgreed) {
                document.getElementById('userAgreementModal').style.display = 'block';
                document.body.classList.add('modal-open');
            }

            let isTagalog = false;
            const englishContent = document.getElementById('modalContent').innerHTML;
            const tagalogContent = `
                <p>Ang PermiSo Website ng POSO-TRU San Pedro ay ganap na sumusunod sa Republic Act No. 10173, na kilala bilang Data Privacy Act of 2012 sa pamamagitan ng pagprotekta at pagseseguro ng pag-iingat ng personal na datos na isinumite sa pamamagitan ng pisikal na dokumento, digital na mail o sa pamamagitan ng aming mga website/portal.</p>
                <p>Ang mga nakolektang impormasyon ay protektado dahil nagpapatupad kami ng mahigpit na mga hakbang sa seguridad sa pamamagitan ng pagpapahintulot lamang sa mga awtorisadong tauhan na mangasiwa sa aming sistema at mga rekord na naglalaman ng sensitibong impormasyon.</p>
                <p>Para sa anumang iba pang alalahanin tungkol sa Paunawa sa Privacy na ito, maaari kang makipag-ugnayan sa aming Administrative office sa landline no. (049) 559-8350 lokal 500-503 o mag-email sa amin sa permiSo.posot.gov.ph.</p>
                <p>Siguraduhin na ibabahagi lang namin ang iyong impormasyon kung kinakailangan ng batas, o kung kinakailangan para sa pagsunod na may kaugnayan sa isang kasunduan sa hindi paghahayag upang panatilihin at tratuhin ang lahat ng iyong impormasyon bilang kumpidensyal.</p>
                <p>Mangyaring suriin nang mabuti ang kasunduan at i-click ang "Sumang-ayon" upang magpatuloy sa dashboard.</p>
            `;

            document.getElementById('translateButton').onclick = function() {
                const modalTitle = document.getElementById('modalTitle');
                const modalContent = document.getElementById('modalContent');
                const translateButton = document.getElementById('translateButton');
                const agreeButton = document.getElementById('agreeButton');
                const exitButton = document.getElementById('exitButton');

                if (isTagalog) {
                    modalTitle.textContent = 'Data Privacy Notice';
                    modalContent.innerHTML = englishContent;
                    translateButton.textContent = 'Translate to Tagalog';
                    agreeButton.textContent = 'Agree';
                    exitButton.textContent = 'Exit';
                } else {
                    modalTitle.textContent = 'Paunawa sa Privacy ng Data';
                    modalContent.innerHTML = tagalogContent;
                    translateButton.textContent = 'Isalin sa Ingles';
                    agreeButton.textContent = 'Sumang-ayon';
                    exitButton.textContent = 'Lumabas';
                }
                isTagalog = !isTagalog;
            };
        });

        document.getElementById('agreeButton').onclick = function() {
            localStorage.setItem('userAgreed', 'true');
            document.getElementById('userAgreementModal').style.display = 'none';
            document.body.classList.remove('modal-open');
        };

        document.getElementById('exitButton').onclick = function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        };
    </script>
</body>
</html>
