
document.addEventListener('DOMContentLoaded', function () {
    const filterBtn = document.getElementById('filterBtn');
    const mapBtn = document.getElementById('mapBtn');
    const desktopFilterMap = document.getElementById('desktopFilterMap');
    const mainContent = document.getElementById('mainContent');
    const mobileFilterModal = document.getElementById('mobileFilterModal');
    const mobileMapModal = document.getElementById('mobileMapModal');
    const closeMobileFilter = document.getElementById('closeMobileFilter');
    const closeMobileMap = document.getElementById('closeMobileMap');
    const productCols = document.querySelectorAll('.row.g-3 > div');

    let isFilterOpen = true; // افتراضي مفتوح في الديسكتوب

    function isDesktop() {
        return window.innerWidth >= 992; // lg breakpoint في Bootstrap
    }

    function toggleDesktopFilter() {
        if (isFilterOpen) {
            desktopFilterMap.classList.add('d-none');
            desktopFilterMap.classList.remove('d-block');
            mainContent.style.width = '80%';
            productCols.forEach(col => {
                col.classList.remove('col-lg-4');
                col.classList.add('col-lg-3');
            });
        } else {

            desktopFilterMap.classList.add('d-block');
            desktopFilterMap.classList.remove('d-none');
            mainContent.style.width = '70%';
            productCols.forEach(col => {
                col.classList.remove('col-lg-3');
                col.classList.add('col-lg-4');
            });
        }
        isFilterOpen = !isFilterOpen;
    }

    function showMobileFilter() {
        mobileFilterModal.classList.add('d-block');
        mobileFilterModal.classList.remove('d-none');
    }

    function hideMobileFilter() {
        mobileFilterModal.classList.add('d-none');
        mobileFilterModal.classList.remove('d-block');
    }

    function showMobileMap() {
        mobileMapModal.classList.add('d-block');
        mobileMapModal.classList.remove('d-none');
    }

    function hideMobileMap() {
        mobileMapModal.classList.add('d-none');
        mobileMapModal.classList.remove('d-block');
    }

    filterBtn.addEventListener('click', function () {
        if (isDesktop()) {
            toggleDesktopFilter();
        } else {
            showMobileFilter();
        }
    });

    mapBtn.addEventListener('click', function () {
        if (!isDesktop()) {
            showMobileMap();
        }
        // في الديسكتوب، يمكن إضافة سلوك إذا لزم الأمر، لكن الخريطة موجودة في الفلتر
    });

    closeMobileFilter.addEventListener('click', hideMobileFilter);
    closeMobileMap.addEventListener('click', hideMobileMap);

    // إغلاق المودال عند النقر خارج المحتوى
    mobileFilterModal.addEventListener('click', function (e) {
        if (e.target === mobileFilterModal) {
            hideMobileFilter();
        }
    });

    mobileMapModal.addEventListener('click', function (e) {
        if (e.target === mobileMapModal) {
            hideMobileMap();
        }
    });

    // تحديث عند تغيير حجم الشاشة
    window.addEventListener('resize', function () {
        if (isDesktop()) {
            // إعادة تعيين إلى الحالة الافتراضية إذا لزم
            if (!isFilterOpen) {
                toggleDesktopFilter();
            }
        } else {
            desktopFilterMap.style.display = 'none';
            mainContent.style.width = ''; // استخدام الـ media queries
        }
    });
});
// Modules/Website/resources/assets/js/app.js (أضف هذا الكود في النهاية)

// جافاسكريبت لتغيير subcategories بناءً على category المختار
document.addEventListener('DOMContentLoaded', function () {
    const categoryRadios = document.querySelectorAll('.category-radio');
    const subcategoryItems = document.querySelectorAll('.subcategory-item');
    const modalSubcategoryItems = document.querySelectorAll('#modal-subcategories-container .subcategory-item');

    function updateSubcategories(selectedCategoryId, container) {
        const items = container.querySelectorAll('.subcategory-item');
        items.forEach(item => {
            const parentId = item.dataset.parentId;
            if (selectedCategoryId === '' || parentId === selectedCategoryId) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    categoryRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedId = this.dataset.categoryId;
            updateSubcategories(selectedId, document.querySelector('#subcategories-container'));
            updateSubcategories(selectedId, document.querySelector('#modal-subcategories-container'));
        });
    });

    // في البداية، أظهر الكل
    updateSubcategories('', document.querySelector('#subcategories-container'));
    updateSubcategories('', document.querySelector('#modal-subcategories-container'));
});

document.addEventListener('DOMContentLoaded', function () {
        // Language Dropdown
        const langBtn = document.getElementById('langBtn');
        const langMenu = document.getElementById('langMenu');

        langBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            langMenu.style.display = langMenu.style.display === 'block' ? 'none' : 'block';
        });

        // تغيير اللغة (مثال - يمكن ربطه بـ route أو localStorage)
        langMenu.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function () {
                const lang = this.getAttribute('data-lang');
                alert('Change language to: ' + lang); // استبدل بـ logic حقيقي
                langMenu.style.display = 'none';
            });
        });

        // إغلاق الدرب داون عند الكليك خارج
        document.addEventListener('click', function () {
            langMenu.style.display = 'none';
        });

        // Profile Dropdown (إذا كان مسجل دخول)
        
            const profileBtn = document.getElementById('profileBtn');
            const profileMenu = document.getElementById('profileMenu');

            if (profileBtn && profileMenu) {
                profileBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function () {
                    profileMenu.style.display = 'none';
                });
            }
    });
