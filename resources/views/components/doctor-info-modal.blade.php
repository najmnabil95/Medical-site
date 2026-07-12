<!-- Store full doctors data for info modal usage -->
@if(!isset($modalDoctorsDataStored))
    <div id="info-modal-doctors-data" data-doctors='{{ json_encode($doctors) }}' class="hidden" aria-hidden="true"></div>
    @php $modalDoctorsDataStored = true; @endphp
@endif

<!-- Doctor Info Modal -->
<div id="doctor-info-modal" class="fixed inset-0 z-100 items-center justify-center p-4" style="display: none;">
  <!-- Backdrop -->
  <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDoctorInfoModal()"></div>
  
  <!-- Modal Content -->
  <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl relative z-10 animate-scale-in max-h-[90vh] flex flex-col overflow-hidden" dir="rtl">
    <!-- Close Button -->
    <button type="button" onclick="closeDoctorInfoModal()" class="absolute top-4 left-4 text-white hover:text-gray-200 transition-colors w-8 h-8 rounded-full bg-black/20 hover:bg-black/40 flex items-center justify-center cursor-pointer z-20">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>

    <!-- Modal Header (Image & Basic Info) -->
    <div class="relative h-64 shrink-0 bg-gray-100">
        <img id="modal-doc-image" src="" alt="Doctor Image" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-linear-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
        <div class="absolute bottom-6 right-6 left-6 text-right text-white">
            <span id="modal-doc-dept" class="inline-block bg-primary-600 text-white px-3 py-1 rounded-full text-xs font-bold mb-3 shadow-md"></span>
            <h3 id="modal-doc-name" class="text-3xl font-black mb-1"></h3>
            <p id="modal-doc-specialty" class="text-gray-200 text-lg font-medium"></p>
        </div>
    </div>

    <!-- Modal Body (Scrollable) -->
    <div class="p-6 md:p-8 overflow-y-auto text-right flex-1">
        
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mb-8 bg-gray-50 rounded-2xl p-4 border border-gray-100">
            <div class="text-center">
                <div class="flex items-center justify-center gap-1 text-yellow-500 mb-1">
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                </div>
                <div id="modal-doc-rating" class="text-lg font-black text-gray-900"></div>
                <div class="text-xs text-gray-500 font-medium">التقييم</div>
            </div>
            <div class="text-center border-r border-gray-200">
                <div class="flex items-center justify-center gap-1 text-primary-500 mb-1">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <div id="modal-doc-exp" class="text-lg font-black text-gray-900"></div>
                <div class="text-xs text-gray-500 font-medium">سنوات الخبرة</div>
            </div>
            <div class="text-center border-r border-gray-200">
                <div class="flex items-center justify-center gap-1 text-blue-500 mb-1">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div id="modal-doc-patients" class="text-lg font-black text-gray-900"></div>
                <div class="text-xs text-gray-500 font-medium">مريض عولج</div>
            </div>
        </div>

        <!-- Description -->
        <div>
            <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5 text-primary-600"></i>
                نبذة عن الطبيب
            </h4>
            <p id="modal-doc-desc" class="text-gray-600 text-sm leading-relaxed whitespace-pre-line"></p>
        </div>
    </div>

    <!-- Modal Footer (Action) -->
    <div class="p-4 md:p-6 bg-gray-50 border-t border-gray-100 shrink-0">
        <button
            type="button"
            id="modal-doc-book-btn"
            class="w-full bg-linear-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold text-base hover:shadow-lg transition-all hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer"
        >
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            <span>احجز موعد مع هذا الطبيب</span>
        </button>
    </div>
  </div>
</div>

<!-- Modal Info Logic Scripts -->
<script>
  let infoModalAllDoctorsList = [];
  
  document.addEventListener("DOMContentLoaded", () => {
    const doctorsDataElement = document.getElementById('info-modal-doctors-data');
    if (doctorsDataElement) {
        infoModalAllDoctorsList = JSON.parse(doctorsDataElement.dataset.doctors);
    }
  });

  function openDoctorInfoModal(doctorId) {
    const doctor = infoModalAllDoctorsList.find(d => d.id == doctorId);
    if (!doctor) return;

    // Populate data
    document.getElementById('modal-doc-image').src = doctor.image;
    document.getElementById('modal-doc-dept').textContent = doctor.department;
    document.getElementById('modal-doc-name').textContent = doctor.name;
    document.getElementById('modal-doc-specialty').textContent = doctor.specialty;
    
    document.getElementById('modal-doc-rating').textContent = doctor.rating;
    document.getElementById('modal-doc-exp').textContent = '+' + doctor.experience;
    document.getElementById('modal-doc-patients').textContent = '+' + doctor.patients;
    
    document.getElementById('modal-doc-desc').textContent = doctor.description || 'لا يوجد وصف متاح حالياً لهذا الطبيب.';

    // Setup Book Button
    const bookBtn = document.getElementById('modal-doc-book-btn');
    bookBtn.onclick = function() {
        closeDoctorInfoModal();
        if(typeof openBookingModal === 'function') {
            openBookingModal(doctor.department, doctor.name);
        }
    };

    // Show modal
    document.getElementById('doctor-info-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
  }

  function closeDoctorInfoModal() {
    document.getElementById('doctor-info-modal').style.display = 'none';
    document.body.style.overflow = '';
  }
</script>
