$(document).ajaxComplete(function (event, xhr, settings) {
    $('.selectpicker').selectpicker('refresh');
initDatePickers();
});

$.ajaxSetup({
    error: function (xhr) {

        if (xhr.status === 403) {

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-left",
                "progressBar": true,
                "timeOut": "2000"
            };
            toastr.error(
                xhr.responseJSON?.message ?? 'Permission not allowed.'
            );
        }
    }
});

function initTagify() {
    $('.basic-tagify').each(function() {
        // Prevent double initialization
        if (!this._tagify) {
            new Tagify(this);
        }
    });
}
initTagify();

function initDatePickers() {
    let dateFormat = typeof date_format !== "undefined" ? date_format : 'MMMM d, yyyy hh:mm T'; 
    
    document.querySelectorAll('.DateTimePicker').forEach((el) => {
        var date_format = $(el).attr('date-format') ? $(el).attr('date-format') : dateFormat;
        new tempusDominus.TempusDominus(el, {
            localization: {
                format: date_format
            },
            useCurrent: true,
            display: {
                components: {
                    
                },
                buttons: {
                    today: true,   
                    clear: false,
                }

            }
        });
    });

}
initDatePickers();


jQuery(document).on('click', ".AjaxOffCanvasShow", function(e) {
    e.preventDefault();

    var url = jQuery(this).attr('href');
    if (!url || url === '#') return;

    // Count currently opened offcanvas
    var openCount = jQuery('.offcanvas.show').length;

    // Create new unique ID
    var newId = 'AjaxOffCanvas_' + (openCount + 1);

    // Z-index stacking logic
    var offcanvasZ = 2000 + (openCount+1);
    var backdropZ = 2000 + (openCount);

    // Clone original template
    var $clone = jQuery('#AjaxOffCanvas').clone();
    $clone.attr('id', newId).css('z-index', offcanvasZ);

    // Append to body
    jQuery('body').append($clone);

    // Initialize Bootstrap offcanvas (disable auto backdrop)
    var offcanvas = new bootstrap.Offcanvas(document.getElementById(newId), {
        scroll: true
    });
    offcanvas.show();

    // Add manual backdrop
   

    // Load AJAX content
    $.get(url)
        .done(function(data) {
            jQuery('#' + newId).html(data);

            var $offcanvasSelects = jQuery('#' + newId).find('.selectpicker');
            if ($offcanvasSelects.length) {
                $offcanvasSelects.selectpicker();
            }

            if (typeof initTagify === "function") {
                initTagify();
            }
        })
        .fail(function() {
            jQuery('#' + newId).html('<p class="text-danger m-auto">Failed to load content.</p>');
        });
});

// Handle offcanvas hidden event
jQuery(document).on('hidden.bs.offcanvas', '.offcanvas', function() {
    var $this = jQuery(this);
    var index = $this.index('.offcanvas');
    // Remove offcanvas
    $this.remove();

    // Remove corresponding backdrop
    jQuery('.offcanvas-backdrop').eq((index-1)).remove();
});

jQuery(document).on('click',"a[data-bs-toggle|='modal'], button[data-bs-toggle|='modal']",function(e){
    e.preventDefault();
    var url           = jQuery(this).attr('href');
    var target        = jQuery(this).data('bs-target');
    // ajax-loader.gif

    if (typeof asset !== 'undefined') {
        const loaderHtml = `
            <div class="d-flex p-3 flex-column align-items-center">
                <img src="${asset}/images/ajax-loader.gif" alt="loading" width="50px" class="loading">
                <span>&nbsp;&nbsp;Loading...</span>
            </div>
        `;

        jQuery(target).find('.modal-content').html(loaderHtml);
    }

    if(typeof target !== "undefined" && target != '' && url != '' && url != '#' && typeof url !== "undefined"){
        
        $.get(url, function(data) {
            $(target).modal('show');
            $('.selectpicker').selectpicker('refresh');
            jQuery(target).find('.modal-content').html(data);
            initTagify();
        });
    }
});


jQuery(document).on('click', '#assign_login', function(){
    if ($(this).is(':checked')) {
        $('#assign_login_role').show();
        $('#assign_login_password').show();
        $('#assign_login_confirm_password').show();
    } else {
        $('#assign_login_role').hide();
        $('#assign_login_password').hide();
        $('#assign_login_confirm_password').hide();
    }
});
jQuery(document).on('click', '#DonotFollowToggle', function(){
    if ($(this).is(':checked')) {
        $('#NoFollowUpReasonText').show();
        $('#RepeatFollowUpSelect').prop('disabled', true);
        $('#RepeatFollowUpNote').prop('disabled', true);
        $('#RepeatFollowUpDate').prop('disabled', true);
        $('.selectpicker').selectpicker('refresh');

    } else {
        $('#NoFollowUpReasonText').hide();
        $('#RepeatFollowUpSelect').prop('disabled', false);
        $('#RepeatFollowUpNote').prop('disabled', false);
        $('#RepeatFollowUpDate').prop('disabled', false);
        $('.selectpicker').selectpicker('refresh');
    }
});

jQuery(document).on('click', '.deleteRecord', function(){
    event.preventDefault();
    var alert_text = jQuery(this).data('alert_text');
    var link = jQuery(this).attr('href');
    deleteSweetAlert(alert_text, link);
});

jQuery(document).on('click', '#CopyToClipBoardBtn', function() {

    let text = $("#CopyToClipBoardInput").val();

    $("#CopyToClipBoardMsg").hide();

    if (navigator.clipboard && navigator.clipboard.writeText) {
        // Modern approach
        navigator.clipboard.writeText(text)
            .then(function () {
                $("#CopyToClipBoardMsg").removeClass('d-none').show().delay(1500).fadeOut();
            })
            .catch(function (err) {
                console.error("Failed to copy: ", err);
            });
    } else {
        // Fallback for older browsers
        copyToClipboard(text);
        $("#CopyToClipBoardMsg").removeClass('d-none').show().delay(1500).fadeOut();
    }
});

function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}

jQuery(document).on('change', '.confirmCheckbox', function(){
    event.preventDefault();
    var alert_text = jQuery(this).data('alert_text');

    if (!this.checked) return;

    const el = this;
    el.checked = false;
    $item = $(this).closest('.verification-item');
    $item.find('.verification-status').removeClass('complete').addClass('pending');
    
    Swal.fire({
        title: 'Are you sure?',
        text: alert_text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        
        if (result.value) {
            el.checked = true;
            $item.find('.verification-status').removeClass('pending').addClass('complete');
        }
    });
});

jQuery(document).on('click', '.confirmEditInvoice', function(){
    event.preventDefault();
    var link = jQuery(this).attr('href');
    var alert_text = jQuery(this).data('alert_text');
    var alert_title = jQuery(this).data('alert_title');

    alert_title = alert_title ? alert_title : 'Are you sure?';
    
    Swal.fire({
        title: alert_title,
        text: alert_text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        
        if (result.value) {
            window.location.href = link;
            return true;
        } else {
            return false;
        }
    });
});

$(document).on('click','#SubmitContactForm',function(e){
    e.preventDefault();
    $('#ContactForm').submit();
});

$(document).on('click','#SubmitContactAssignLoginForm',function(e){
    e.preventDefault();
    $('#ContactAssignLoginForm').submit();
});


$(document).on('submit','#ContactForm',function(e){
    e.preventDefault();
  
    var form = $(this);
    var formData = new FormData(this); 
    $('.error-text').text('');

    form.find('.formLoading').removeClass('d-none');

    $.ajax({
        url: form.attr('action'), 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
          if (response.success) {
            
            var ActionUrl = $('#AjaxFilterForm').attr('action');
            loadLeads(ActionUrl);

            $('.contact-dropdown').replaceWith(response.dropdown);

            let offcanvasEl = form.closest('.offcanvas')[0];
            let offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl) 
                || new bootstrap.Offcanvas(offcanvasEl);
            offcanvas.hide();

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-left",
                "progressBar": true,
                "timeOut": "2000"
            };
            toastr.success(response.message);
          }
        },
        error: function(response) {
            form.find('.formLoading').addClass('d-none');
            var errors = response.responseJSON.errors;

            $.each(errors, function(key, value) {
                form.find('.' + key + '_error').text(value); 
            });
        }
    });

    if ($(this).attr('data-redirct-offcanvas')) {
        
    }
});

$(document).on('submit','#ContactAssignLoginForm',function(e){
    e.preventDefault();
  
    var form = $(this);
    $('.error-text').text('');
    form.find('.formLoading').removeClass('d-none');

    $.ajax({
        url: form.attr('action'), 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          if (response.success) {

            let offcanvasEl = form.closest('.offcanvas')[0];
            let offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl) 
                || new bootstrap.Offcanvas(offcanvasEl);
            offcanvas.hide();
            
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-left",
                "progressBar": true,
                "timeOut": "2000"
            };
            toastr.success(response.message);
                        // window.location.reload();

          }
        },
        error: function(response) {
            form.find('.formLoading').addClass('d-none');
            var errors = response.responseJSON.errors;

            $.each(errors, function(key, value) {
                form.find('.' + key + '_error').text(value); 
            });
        }
    });
});


$(document).on('change','#QuotationMaterialCategory',function(e){
    e.preventDefault();
  
    var category_id = $('#QuotationMaterialCategory').val();
    var company_id = $('#QuotationMaterialBrands').val();
    $('#QuotationMaterialBrands').attr('data-category',category_id);
    var url = $(this).data('url');
    var container = $(this).data('ajax-container');

    $.ajax({
        url: url, 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {category_id:category_id,company_id:company_id},
        success: function (response) {
          $(container).html(response);
            $('.selectpicker').selectpicker('refresh');
          
        },
        error: function(response) {
        }
    });
});

$(document).on('click','.deleteClientGroup',function(e){
    e.preventDefault();
  
    var $this = $(this);

   /* Swal.fire({
        title: 'Are you sure to delete?',
        text: 'Are you sure to delete this Client Group.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.value) {*/
            $.ajax({
                url: $this.attr('href'), 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                  $this.closest('tr').remove();
                },
                error: function(response) {
                }
            });
        /*}
    });*/
});

$(document).on('submit','#ClientGroupModalForm',function(e){
    e.preventDefault();
  
    var form = $(this);
    $('.error-text').text('');
    form.find('.formLoading').removeClass('d-none');

    $.ajax({
        url: form.attr('action'), 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {

            if (response.status) {
                form.find('.formLoading').addClass('d-none');

                toastr.options = {
                    "closeButton": true,
                    "positionClass": "toast-top-left",
                    "progressBar": true,
                    "timeOut": "2000"
                };

                if (response.message) {
                    toastr.success(response.message);
                }
                $('#ClientGroupTableBody').append(response.html);
                form[0].reset();
                return;
            }
            toastr.error('Something went wrong. Please try again.');

        },
        error: function(response) {
            form.find('.formLoading').addClass('d-none');
            var errors = response.responseJSON.errors;

            if (errors) {
                $.each(errors, function(key, value) {
                    form.find('.' + key + '_error').text(value); 
                });
            }
        }
    });
});

function calculateQuotation() {
    var itemsSubTotal = 0;
    var itemsDiscount = 0;
    var itemsTax = 0;

    $('.quotationItem').each(function () {
        var qty = parseFloat($(this).find('.quantity').val()) || 0;
        var price = parseFloat($(this).find('.price').val()) || 0;
        var taxPercent = parseFloat($(this).find('.tax').val()) || 0;
        var discountPercent = parseFloat($(this).find('.discount').val()) || 0;

        var rowSubTotal = qty * price;
        var rowDiscount = rowSubTotal * (discountPercent / 100);

        // Tax after discount
        var taxableAmount = rowSubTotal - rowDiscount;
        var rowTax = taxableAmount * (taxPercent / 100);

        var rowTotal = taxableAmount + rowTax;

        // Totals
        itemsSubTotal += rowSubTotal;
        itemsDiscount += rowDiscount;
        itemsTax += rowTax;

        $(this).find('.total-text').text(rowTotal.toFixed(2));
        $(this).find('.item-total').val(rowTotal.toFixed());
    });
    
    
    var orderTaxPercent = parseFloat($('#order_tax').val()) || 0;
    var additionalDiscountPercent = parseFloat($('#additional_discount').val()) || 0;
    var additionalCharges = parseFloat($('#additional_charges').val()) || 0;
    var solorCapacity = $('#SolorCapacitySelect').val();

    if (typeof quotation_calculate_url !== 'undefined' && quotation_calculate_url) {

        $.ajax({
            url: quotation_calculate_url,
            data: {
                items_subtotal:itemsSubTotal,
                items_discount:itemsDiscount,
                items_tax:itemsTax,
                order_tax_percent:orderTaxPercent,
                additional_discount_percent:additionalDiscountPercent,
                additional_charges:additionalCharges,
                solor_capacity:solorCapacity
            }, 
            success: function (response) {
                $('#QuotationCalculationContainer').html(response.html);
                $('.selectpicker').selectpicker('refresh');
            },
            error: function(response) {
            }
        });
    }

    
}

$(document).on('click','#AddQuotationMaterialItem',function(e){
    e.preventDefault();
    var itemId = jQuery('#QuotationMaterialItem').val();
    var itemLength = $(".quotationItem").length;
    var rowLength = $("#QuotationBodyTable tr").length;
    var url = jQuery('#QuotationMaterialItem').attr('data-url')+'/'+itemId;
    
    var existingRow = $('#QuotationBodyTable tr').filter(function () {
        return $(this).data('item') == itemId;
    });

    if (existingRow.length > 0 && false) {

        var qtyInput   = existingRow.find('.quantity');
        var priceInput = existingRow.find('.price');
        var totalInput = existingRow.find('.total');

        var qty   = parseInt(qtyInput.val()) || 0;
        var price = parseFloat(priceInput.val()) || 0;

        qty += 1; 
        var total = qty * price;

        qtyInput.val(qty);
        totalInput.text(total.toFixed(2));
        calculateQuotation();
    } else {
        $.ajax({
            url: url,
            data: {item_length:itemLength,row_length:rowLength}, 
            success: function (response) {
                $('#QuotationBodyTable').append(response);
                $('.selectpicker').selectpicker('refresh');
                calculateQuotation();
            },
            error: function(response) {
            }
        });
    }
});

const quotationFields = `
    #QuotationBodyTable .quantity,
    #QuotationBodyTable .price,
    #QuotationBodyTable .tax,
    #QuotationBodyTable .discount,
    #order_tax,
    #additional_discount,
    #additional_charges,
    #SolorCapacitySelect
`;
var quotationCalculateTimer = null;
$(document).off('input change', quotationFields).on('input change', quotationFields, function () {
    clearTimeout(quotationCalculateTimer);
    quotationCalculateTimer = setTimeout(function () {
        calculateQuotation();
    }, 800);
});

$(document).ready(function () {
    calculateQuotation();
});

jQuery(document).on('click','.RemoveQuotationItem',function(e){
    e.preventDefault();
    $this = $(this);
    
    Swal.fire({
        title: 'Are you sure to delete?',
        text: 'Are you want to remove this quotation item.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.value) {
            if ($this.data('url')) {
                $.ajax({
                    url: $this.data('url'), 
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Item removed Successfully.');
                    },
                    error: function(response) {
                        alert('There is some problem.');
                    }
                });
            }

            jQuery(this).closest('.quotationItem').remove();
            calculateQuotation();

        }else{
            return true;
        }
    });
});

if(jQuery('.touchspin-input').length > 0 ){
    $('.touchspin-input').TouchSpin({
        step: 1,
        buttondown_class: 'btn bg-primary-subtle rounded-0 rounded-start',
        buttonup_class: 'btn bg-primary-subtle rounded-0 rounded-end'
    });
}

document.addEventListener("click", function (e) {
    const dropdownMenus = document.querySelectorAll('.on-dropdown-menu');
    if (!e.target.closest(".dropdown-slt")) {
        dropdownMenus.forEach((item) => {
            item.style.display = "none";
        })
    }
});
jQuery(document).on('focus','.on-dropdown-name-input',function(){
    jQuery(jQuery(this).attr('data-dropdown-target')).css('display','flex');
});
jQuery(document).on('click','.on-dropdown-item',function(){
    $(this).closest('.dropdown-slt').find('.on-dropdown-id-input').val($(this).data('id'));
    $(this).closest('.dropdown-slt').find('.on-dropdown-name-input').val($(this).data('name'));
    $(this).closest('.dropdown-slt').find('.on-dropdown-menu').hide();
    $(this).closest('.dropdown-slt').find('.party-item.on-dropdown-item').removeClass('bg-primary-subtle');
    $(this).addClass('bg-primary-subtle');

});

jQuery(document).on('input', '.on-dropdown-name-search', function () {

    let search = jQuery(this).val().toLowerCase();
    let dropdown = jQuery(this).closest('.on-dropdown-menu');
    let items = dropdown.find('.on-dropdown-item');
    let button = dropdown.find('.AjaxOffCanvasShow');
    let found = false;

    items.each(function () {

        let name = jQuery(this).data('name').toLowerCase();

        if (name.includes(search)) {
            jQuery(this)
                .removeClass('d-none')
                .addClass('d-flex');

            found = true;

        } else {
            jQuery(this)
                .removeClass('d-flex')
                .addClass('d-none');
        }
    });

    dropdown.find('.no-results').remove();

    if (!found) {
        jQuery(`
            <div class="no-results text-muted text-center p-2">
                No Results Matched '${search}'
            </div>
        `).insertBefore(button);
    }
});

jQuery(document).off('change", "#EnableSolarKitCheck, #ProjectTypeSelect').on('change','#EnableSolarKitCheck, #ProjectTypeSelect',function(){
    let url = $('#EnableSolarKitCheck').data('url');
    let EnableSolarKitCheck = $('#EnableSolarKitCheck').is(':checked');
    let ProjectTypeSelectValue = $('#ProjectTypeSelect').val();

    $.ajax({
        url: url,
        data: {is_solar_kit_project:EnableSolarKitCheck,project_type:ProjectTypeSelectValue}, 
        success: function (response) {
            $('#SolarItemsContainer').html(response);
            $('.brand-select').trigger('change');
                calculateQuotation();

        },
        error: function(response) {
        }
    });
});
jQuery(document).off('change','.quotationItemSelect').on('change','.quotationItemSelect',function(){
    let price = $(this).find(':selected').data('price');
    let gst = $(this).find(':selected').data('gst');
    let description = $(this).find(':selected').data('description');
    let item_unit = $(this).find(':selected').data('unit');
    
    $(this).closest('.quotationItem').find('.item-description').text(description);
    $(this).closest('.quotationItem').find('.price').val(price);
    $(this).closest('.quotationItem').find('.tax').val(gst);
    $(this).closest('.quotationItem').find('.item-unit').text(item_unit);

    calculateQuotation();

});

/* For Project add / edit time select Items by Brands and Categories */
$(document).on('change', '.brand-select', function () {
    let companyId = $(this).val();
    let category_id = $(this).data('category');
    let target = $($(this).data('target'));
    let selectedItems = $(this).data('selected-items') || [];

    target.html('<option>Loading...</option>');

    if (!companyId) {
        target.html('<option value="">Select Item</option>');
        return;
    }

    $.get(brand_select_route, {
        company_id: companyId,
        category_id: category_id
    }, function (response) {
        let options = '<option value="" >Select Item</option>';
        $.each(response, function (key, item) {
            
            selectedItems = selectedItems.map(Number);
            let selected = selectedItems.includes(item.id) ? 'selected' : '';
            options += `<option value="${item.id}" ${selected} data-description="${item.description}" data-unit="${item.material_unit.title}" data-price="${item.selling_price}" data-weight_per_piece="${item.weight_per_piece}" data-gst="${item.gst}">${item.title}</option>`;
        });

        target.html(options);
        $('.selectpicker').selectpicker('refresh');
    });
});

$('.brand-select').each(function () {
    if ($(this).val()) {
        $(this).trigger('change');
    }
});


function deleteSweetAlert(alert_text, link)
{
    Swal.fire({
        title: 'Are you sure to delete?',
        text: alert_text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            window.location.href = link;
            return true;
        } else {
            return false;
        }
    })
}

function togglePassbook() {
    if (jQuery('#govtSubsidy').is(':checked')) {
        jQuery('.subsidy-inputs').show();
        jQuery('#SubsidyTypeInput').show();
    } else {
        jQuery('.subsidy-inputs').hide();
        jQuery('#SubsidyTypeInput').hide();
    }
}
togglePassbook();
$('#govtSubsidy').change(togglePassbook);


function collectFilters() {
    var data = {};

    $('#AjaxFilterForm')
        .serializeArray()
        .forEach(function (field) {
            if (data[field.name]) {
                if (!Array.isArray(data[field.name])) {
                    data[field.name] = [data[field.name]];
                }
                data[field.name].push(field.value);
            } else {
                data[field.name] = field.value;
            }
        });

    return data;
}

jQuery(document).on('click', '#ResetAjaxFilter', function (e) {
    e.preventDefault();

    // Reset the form
    $('#AjaxFilterForm')[0].reset();

    // Optional: clear custom selects (if using select2 etc.)
    $('#AjaxFilterForm').find('select').val('').trigger('change');

    // Reload results
    var ActionUrl = $('#AjaxFilterForm').attr('action');
    loadLeads(ActionUrl);
});

jQuery(document).on('input change click', '.ApplyAjaxFilter', function(e){
    
    if (this.type !== 'checkbox') {
        e.preventDefault();
    }

    var ActionUrl = $('#AjaxFilterForm').attr('action');

    loadLeads(ActionUrl);
});

$(document).on('click', '#AjaxTablePagination .pagination a', function (e) {
    e.preventDefault();

    var ActionUrl = $(this).attr('href');

    loadLeads(ActionUrl);
});

if ($('#AjaxFilterForm').length > 0) {
    var ActionUrl = $('#AjaxFilterForm').attr('action');
    loadLeads(ActionUrl);
}
function loadLeads(ActionUrl){
    var filterValues = collectFilters();

    $.ajax({
        url: ActionUrl, 
        method: 'GET',
        data: filterValues,
        success: function (response) {
            if (response.responce_for == 'leads') {
                $('#LeadsTableContainer').html(response.LeadsTableContent)
                $('#LeadsCardsContainer').html(response.LeadsCardsContent)
            }
            if (response.responce_for == 'contacts') {
                $('#ContactsTableContainer').html(response.ContactsTableContent)
            }
        },
        error: function(response) {
            
        }
    });
}

$(document).on('change','#BusinessDashboardFilterSelect',function(e){
    
    if ($(this).val() == 'range') {
        $('#BusinessDashboardFilterRange').show();
    }else{
        $('#BusinessDashboardFilterRange').hide();
    }
    
});

$(document).on('submit','#FilterBusinessDashboardForm',function(e){
    e.preventDefault();
    
    var url = $(this).attr('action');
    var container = 'BusinessDashboardWidgets';
    var FormData = $(this).serialize();

    var data = [];
    data.ajax_url = url;
    data.form_data = FormData;
    data.ajax_container = container;

    run_ajax(data);
});

function run_ajax(data){
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: data.ajax_url,
        method: 'GET',
        data: data.form_data,
        success: function(response) {
            $('#'+data.ajax_container).html(response);
        },
        error: function(response) {
        }
    });
}


var SolarMitra = function(){
    "use strict"


    var handleModalCloseOffcanvas = function () {
        const offcanvasElements = document.querySelectorAll('.TriggerOffcanvas');
        const modalElements = document.querySelectorAll('.TriggerModal');

        offcanvasElements.forEach(offcanvas => {
            offcanvas.addEventListener('show.bs.offcanvas', event => {
                // Remove all modal backdrops
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

                // Hide all modals using Bootstrap API or fallback
                modalElements.forEach(modal => {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    } else {
                        modal.classList.remove('show');
                        modal.setAttribute('aria-hidden', 'true');
                        modal.style.display = 'none';
                    }
                });

                // Reset body scroll state
                document.body.classList.remove('modal-open');
                document.body.style.overflow = null;
                document.body.style.paddingRight = null;
            });
        });
    };


    let topIndex = 2000;
    var handleZIndexModalAndOffcanvas = function () {
        // Modal events
        document.addEventListener('shown.bs.modal', function (e) {
            $('.modal-backdrop').css('z-index',topIndex);
            bringToFront(e.target);
        });

        // Offcanvas events
        document.addEventListener('shown.bs.offcanvas', function (e) {

            let count = document.querySelectorAll('.offcanvas.show').length;

            let backdrop = document.querySelectorAll('.offcanvas-backdrop');
            if (backdrop.length) {
                backdrop[backdrop.length - 1].style.zIndex = topIndex + count;
            }

            bringToFront(e.target);
        });
    };

    // Bring any opened element to front
    function bringToFront(element) {
        topIndex = topIndex+3;
        element.style.zIndex = topIndex;
    }

    var handleImgOnChange = function () {
        let $currentBox = null;
        let uploadCounter = $('.uploadNext').length || 0;

        $(document).off('change", ".img-business-input-onchange').on("change", ".img-business-input-onchange", function () {
            const input = this;
            const file = input.files && input.files[0];
            if (!file) return;

            // Optional: image-only validation
            // if (!file.type.startsWith("image/")) return;

            const $parentBox = $(input).closest('.img-parent-box');
            let $targetBox = $parentBox;

            if ($parentBox.hasClass('uploadNext')) {
                $targetBox = $parentBox.clone();
                $targetBox.find('[id]').removeAttr('id');

                const $oldInput = $parentBox.find('.img-business-input-onchange');
                const $newInput = $oldInput.clone().val('');
                $oldInput.replaceWith($newInput);

                $parentBox.before($targetBox);
            }

            const $img = $targetBox.find('.img-for-onchange');
            let pdf_icon = $img.data('pdf-icon');

            const oldSrc = $img.attr('src');
            if (oldSrc && oldSrc.startsWith('blob:')) {
                URL.revokeObjectURL(oldSrc);
            }

            if (file.type === "application/pdf") {
                var imageUrl = pdf_icon;
            }else{
                var imageUrl = URL.createObjectURL(file);
            }
            
            $img
                .attr('src', imageUrl)
                .show()
                .removeAttr('id');

            $targetBox.find('.cancel-img-btn').show();
            $targetBox.find('.upload-label').hide();
        });

        // Show modal and preview image
        $(document).on('click', '.cancel-img-btn', function () {

            $currentBox = $(this).closest('.img-parent-box');

            var imgSrc = $currentBox.find('.img-for-onchange').attr('src');
            $("#previewImageInModal").attr('src', imgSrc);
            $("#confirmRemoveImageBtn").data('url', $(this).attr('href'));

            const modal = new bootstrap.Modal(document.getElementById('imageRemoveConfirmModal'));
            modal.show();
        });

        // Confirm remove
        $(document).on('click', '#confirmRemoveImageBtn', function () {

            if ($currentBox) {

                let inputId = $currentBox.find(".img-business-input-onchange").attr("id");
                const url = $(this).data('url');

                
                if ($currentBox.hasClass('uploadNext')) {
                    $currentBox.remove();   // remove only THIS appended div
                } 
                else {
                    
                    $currentBox.find('.img-for-onchange').attr('src', '').hide();
                    $currentBox.find('.upload-label').show();
                    $currentBox.find('.img-business-input-onchange').val('');
                    $currentBox.find('.cancel-img-btn').hide();
                }
                if (url) {
                    $.get(url)
                }

                $currentBox = null;

                const modal = bootstrap.Modal.getInstance(document.getElementById("imageRemoveConfirmModal"));
                modal.hide();

                toastr.options = {
                    "closeButton": true,
                    "positionClass": "toast-top-left",
                    "timeOut": "3000"
                };
                toastr.success("Image removed successfully.");
            }
        });
    };

    var handleImgZoom = function () {
        $('.zoomable').on('click', function (e) {
            e.preventDefault();

            let src = $(this).attr('data-src') || $(this).attr('src');
            let IsIframe = src.toLowerCase().endsWith('.pdf') ? true : false;

            
            $(this).lightGallery({
                dynamic: true,
                dynamicEl: [{
                    iframe: IsIframe,
                    src: src
                }],
                zoom: true
            });
        });
    };

    var handleShowPass = function(){
        jQuery(document).on('click','.show-pass',function(){
            var inputParent = jQuery(this).parent();
            var inputType = inputParent.find('.dz-password');
            if(inputType.attr('type') == 'password')
            {
                jQuery(this).addClass('active');
                inputType.attr('type', 'text');
            }
            else
            {
                jQuery(this).removeClass('active');
                inputType.attr('type', 'password');
            }
        });
    }

    var handleDropdownSubmenu = function () {

        $(document).on('mouseenter', '.dropdown-submenu', function () {
            $(this).find('.dropdown-menu').addClass('show');
        });

        $(document).on('mouseleave', '.dropdown-submenu', function () {
            $(this).find('.dropdown-menu').removeClass('show');
        });

    };

    var handleTblOptions = function () {
        if (jQuery('.leads-tbl tbody .check-input').length > 0) {
 
            // run once on load
            if ($('.leads-tbl tbody .check-input:checked').length > 0) {
                $('#tblOptions').show(); // no animation on load
            } else {
                $('#tblOptions').hide();
            }
 
            // on checkbox change
            $(document).on('change', '.leads-tbl tbody .check-input', function () {
                
                setTitleAndAllCheck($('.check-input:checked').length + ' Records Selected')

            });
 
        }
    };

    function setTitleAndAllCheck(Text=null){
        if (jQuery('.CheckAllInputs').length > 0) {
            $('.CheckAllInputs').prop(
                'checked',
                $('.check-input:checked').length === $('.check-input').length
            );
        }
        if ($('.check-input:checked').length > 0) {
            $('#SelectedItemsTextBox').text(Text);
        }else{
            $('#SelectedItemsTextBox').text('');
        }
    }

    var handleLeadStageDropdownItem = function () {
        if (jQuery('.LeadStageDropdownItem').length > 0) {
 
            // on checkbox change
            $(document).on('click', '.LeadStageDropdownItem', function () {
                var selectedStage = $(this).data('value');
                var stageTitle = $(this).text();

                // Uncheck all first
                $('.check-input').prop('checked', false);

                // Check only matching stage
                $('.check-input[data-stage-id="' + selectedStage + '"]').prop('checked', true);

                setTitleAndAllCheck($('.check-input:checked').length + ' ' + stageTitle + ' Records Selected');

            });
            
        }
        $(document).on('change', '.CheckAllInputs', function () {
            $('.check-input').prop('checked', $(this).is(':checked'));
            setTitleAndAllCheck($('.check-input:checked').length + ' Records Selected')

        });
    };

    var handleBulkDelete = function () {
        if (jQuery('.BulkDeleteBtn').length > 0) {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-left",
                "progressBar": true,
                "timeOut": "2000"
            };
 
            $(document).on('click', '.BulkDeleteBtn', function (e) {
                e.preventDefault(); // prevent normal link redirect

                let url = $(this).attr('href');
                var alert_text = $(this).data('alert_text');
                var button_text = $(this).data('button_text') ?? 'Yes, update it!';

                // Get all checked checkbox values
                let selectedLeads = $('.check-input:checked').map(function () {
                    return $(this).val();
                }).get();
                

                if (selectedLeads.length === 0) {
                    toastr.warning('Please select at least one Record.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: alert_text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: button_text
                }).then((result) => {

                    if (result.value) {

                        $.ajax({
                            url: url,
                            type: 'POST',
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                selected_leads: selectedLeads,
                            },
                            success: function (response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    selectedLeads.forEach(function (id) {
                                        $('#Row_' + id).fadeOut(1000, function() {
                                            // 
                                        });
                                    });

                                }
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        }
    };

    var handleLeadChangeStatus = function () {
        if (jQuery('.LeadChangeStatus').length > 0 || 
            jQuery('.LeadClientGroup').length > 0 || 
            jQuery('.LeadSource').length > 0  || 
            jQuery('.LeadPotential').length > 0 ) {
            
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-left",
                "progressBar": true,
                "timeOut": "2000"
            };

            $(document).on('change', '.LeadChangeStatus, .LeadClientGroup, .LeadSource, .LeadPotential', function (e) {
                e.preventDefault();

                let url = $(this).closest('.dropdown-menu').data('url');
                let inputValue = $(this).val();
                var alert_text = $(this).closest('.dropdown-menu').data('alert_text');

                let selectedLeads = $('.check-input:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedLeads.length === 0) {
                    toastr.warning('Please select at least one lead.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: alert_text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {

                    if (result.value) {

                        $.ajax({
                            url: url,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                selected_leads: selectedLeads,
                                value: inputValue,
                            },
                            success: function (response) {
                                if (response.status) {
                                    toastr.success(response.message);

                                    var ActionUrl = $('#AjaxFilterForm').attr('action');
                                    loadLeads(ActionUrl);
                                }
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                            }
                        });

                    } else {
                        // Optional: reset dropdown to previous value if cancelled
                        // location.reload(); 
                    }
                });
            });
        }
    };

    var handleSetQuotationTitle = function () {
        if (jQuery('#SetQuotationTitle').length > 0 ) {

            $(document).on('input change', '#ProjectTypeSelect, #SolorCapacitySelect' , function () {

                SetTitles();
            });
            $(document).on('click', '.on-dropdown-menu .on-dropdown-item' , function () {

                SetTitles();
            });
        }
    };

    function SetTitles() {
        let clientTitle      = $('#ClientTitle').val();
        let solorCapacity       = $('#SolorCapacitySelect').val();
        let projectType         = $('#ProjectTypeSelect').val();
        
        let title = '';

        if (clientTitle)     title += clientTitle;
        if (solorCapacity)      title += ' - ' + solorCapacity;
        if (projectType)        title += ' - ' + projectType;

        $('#ProjectTitle').val(title);
        $('#ProjectTitle').html(title);


        var qtPrefix = $('#QuotationTitlePrefix').val() || 'QT -';
        $('#SetQuotationTitle').val(qtPrefix + ' ' + title);
        $('#SetQuotationTitle').html(' - ' + qtPrefix + ' ' + title);
    }

    var handleQuotation = function () {
        if (jQuery('.addMoreItem').length > 0) {
            jQuery(document).on('click',".addMoreItem", function(e) {
                e.preventDefault();
                const itemClass     = jQuery(this).attr("data-item-class");
                const itemContainer = jQuery(this).attr("data-item-container");
                const itemModal     = jQuery(this).attr("data-model");
                const itemSlug      = jQuery(this).attr("data-slug");
                const itemLimit     = jQuery(this).attr("data-item-limit");
                const itemLimitMsg  = jQuery(this).attr("data-limit-message");
                const ajaxUrl       = jQuery(this).attr("data-url");
                const catId         = jQuery(this).attr("data-category-id");

                const quotationItemCount = jQuery(".quotationItem").length;

                let maxCount = $(`.${itemContainer}`).children().length;

                if(maxCount > itemLimit) {
                    const message = document.createElement("p");
                    message.textContent = itemLimitMsg;
                    message.classList = "ms-3 mt-3 text-danger";
                    $(this).parent().append(message);
                    return;
                }

                $.ajax({
                  type: "GET",
                  url: ajaxUrl,
                  data: { title: itemModal, nextItemCount: quotationItemCount, catId: catId, slug: itemSlug }
                }).done(function( data ) {
                    $(`.${itemContainer}`).append(data);
                    $(".remove-item").on('click',function(e) {
                        e.preventDefault();
                        $(this).parent().remove();
                    })

                });

            })
        }
    };

    /*-- Project Info Edit Toggle --*/
    var handleCardProjectCardShowHide = function () {

        // Hide edit card on page load
        $('.editProjectInfo').hide();

        // Show edit card, hide view card on Edit click
        $(document).on('click', '.editProjectInfoBtn', function () {
            $('.showProjectInfo').fadeOut(300, function () {
                $('.editProjectInfo').fadeIn(300);
            });
        });

        // Show view card, hide edit card on Save click
        $(document).on('click', '.projectInfoCancel', function () {
            $('.editProjectInfo').fadeOut(300, function () {
                $('.showProjectInfo').fadeIn(300);
            });
        });

    }

    var handleProjectWizard = function () {
        
        /*=====================
        Solar Project Wizard JS
        ==========================*/

        var currentStep = 1;

        var stepName= $('#projectStep').attr('data-step');

        var totalSteps  = 6;

        if(stepName === "verification"){
            currentStep = 2;
        }else if(stepName === "subsidy"){
            currentStep = 3;
        }else if(stepName === "structure"){
            currentStep = 4;
        }else if(stepName === "netmeter"){
            currentStep = 5;
        }else if(stepName === "handover"){
            currentStep = 6;
        }

       function init() {
            for (var i = 1; i <= totalSteps; i++) {
                $('.wizard-step-' + i).addClass('d-none').removeClass('d-block');
                $('.step-' + i).removeClass('active').removeClass('disabled');
            }
            showStep(currentStep);
        }

        let availableSteps = [];

        $('.step-container').each(function () {
            const match = $(this).attr('class').match(/step-(\d+)/);

            if (match) {
                availableSteps.push(parseInt(match[1]));
            }
        });

         init();

        function showStep(step) {

            for (var i = 1; i <= totalSteps; i++) {
                $('.wizard-step-' + i).addClass('d-none').removeClass('d-block');
            }

            $('.wizard-step-' + step).removeClass('d-none').addClass('d-block');

            for (var i = 1; i <= totalSteps; i++) {
                if (i < step) {
                    $('.step-' + i).removeClass('active').addClass('disabled');
                } else if (i === step) {
                    $('.step-' + i).addClass('active').removeClass('disabled');
                } else {
                    $('.step-' + i).removeClass('active').removeClass('disabled');
                }
            }

            if (step === availableSteps[0]){
                $('.project-previous').hide();
            } else {
                $('.project-previous').show();
            }

            if (step === availableSteps[availableSteps.length - 1]){
                $('.project-next').hide();
            } else {
                $('.project-next').show();
                $('.project-next').html('Next <i class="icon-arrow-right ms-2"></i>');
            }
        }

        $(document).on('click', '.project-next', function (e) {
            e.preventDefault();

            const currentIndex = availableSteps.indexOf(currentStep);

            if (currentIndex < availableSteps.length - 1) {
                currentStep = availableSteps[currentIndex + 1];
                showStep(currentStep);
            }
        });

        $(document).on('click', '.project-previous', function (e) {
            e.preventDefault();

            const currentIndex = availableSteps.indexOf(currentStep);

            if (currentIndex > 0) {
                currentStep = availableSteps[currentIndex - 1];
                showStep(currentStep);
            }
        });
        
        
    }

    function showExistingImage(dz, image, field, type, pdf_thumb){

        let files = JSON.parse(image);

        if(type === "multiple"){
            if(!Array.isArray(files)){
                files = Object.values(files);
            }
        }else{
            if(!Array.isArray(files)){
                files = [files];
            }
        }

        files.forEach(function(file){
            let mockFile = {};
            if(type === "multiple"){
                mockFile = {
                    name: field,
                    isExisting: true,
                    attachmentId: file.attachment_id,
                    size: file.size || 123456
                };
            }else{
                mockFile = {
                    name: field,
                    isExisting: true,
                    size: file.size || 123456
                };
            }

            dz.emit("addedfile", mockFile);

            if(type === "video"){

                // video preview
                const video = document.createElement("video");
                video.src = file.file_url;
                video.controls = true;
                video.style.width = "100%";
                video.style.height = "120px";

                const preview = mockFile.previewElement.querySelector(".dz-image");
                preview.innerHTML = "";
                preview.appendChild(video);

            }else{

                const imageView = document.createElement("div");
                const imageViewIcon = document.createElement("i");
                imageView.classList = "dz-view zoomable";

                imageView.setAttribute("data-src",file.file_url);


                imageViewIcon.classList = "fa fa-eye";
                imageView.appendChild(imageViewIcon);
                const preview = mockFile.previewElement.querySelector(".dz-details");
                preview.appendChild(imageView);

                // image preview
                if (file.type === 'application/pdf') {
                    dz.emit("thumbnail", mockFile, pdf_thumb);
                }else{
                    dz.emit("thumbnail", mockFile, file.file_url);
                }

            }

            dz.emit("complete", mockFile);

            dz.files.push(mockFile);

        });
        if(type === "multiple"){
            dz.options.maxFiles = dz.options.maxFiles - files.length;
        }

    }

    var handleProjectDropzone = function(){

        let myDropzones = [];

        document.querySelectorAll(".project-dropzone").forEach(function(el){

            if(el.dropzone) return;

            let field = el.dataset.field;
            let type = el.dataset.type; // image or video
            let maxFiles = 1;
            let image = el.dataset.image;
            let pdf_thumb = el.dataset.pdf_thumb;
            let imageRemoveUrl = el.dataset.removeUrl;

            let form = el.closest("form");
            let input = form.querySelector('input[name="' + field + '"]');

            let acceptedFiles = `image/jpeg,image/png,image/webp,image/gif,image/jpg,image/svg+xml,image/bmp,image/tiff,image/avif,application/pdf`;
            if(type === "multiple"){
                maxFiles = 6;
            }
            if(type === "video"){
                acceptedFiles = "video/mp4,video/webm,video/ogg";
            }
            
            let dz = new Dropzone(el, {

                url: "#",
                autoProcessQueue: false,
                maxFiles: maxFiles,
                parallelUploads: maxFiles,
                addRemoveLinks: imageRemoveUrl ? true : false,
                dictRemoveFileConfirmation: "Are you sure you want to remove this file?",
                acceptedFiles: acceptedFiles

            });

            dz.on("maxfilesexceeded", function (file) {

                // allow multiple gallery uploads
                if(type === "multiple"){
                    dz.removeFile(file);
                    toastr.warning("Maximum file limit reached.");
                    return;
                }

                // replace existing file for single upload
                if(dz.files.length){
                    dz.files[0].replaced = true;
                }

                dz.removeAllFiles();
                dz.addFile(file);

            });
           
            dz.on("addedfile", function(file){

                // VIDEO PREVIEW
                if(file.type && file.type.startsWith("video")){

                    const video = document.createElement("video");
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.style.width = "100%";
                    video.style.height = "120px";

                    file.previewElement.querySelector(".dz-image").innerHTML = "";
                    file.previewElement.querySelector(".dz-image").appendChild(video);
                }

                // remove existing preview only for single upload
                if(type !== "multiple" && dz.files.length > 1){

                    dz.files.forEach(function(f){
                        if(f.isExisting){
                            f.replaced = true;
                            dz.removeFile(f);
                        }
                    });

                }

            });

            dz.on("addedfiles", function(){

                if (!input) return;

                let dt = new DataTransfer();

                dz.files.forEach(function(f){
                    if(f instanceof File){
                        dt.items.add(f);
                    }
                });

                input.files = dt.files;

            });

            dz.on("removedfile", function (file) {

                if(file.isExisting && !file.replaced){
                    if(file.attachmentId){
                        $.get(imageRemoveUrl+'/'+file.attachmentId);
                    }else{
                        $.get(imageRemoveUrl);
                    }
                    toastr.success("File removed successfully.");
                }

                if (!input) return;

                let dt = new DataTransfer();

                dz.files.forEach(function(f){
                    if(f instanceof File){
                        dt.items.add(f);
                    }
                });

                input.files = dt.files;

            });
         
            // showExistingImage(dz, image, field);
            if(image && !image.includes("noimage.jpg")){
                showExistingImage(dz, image, field, type, pdf_thumb);
            }

            myDropzones.push(dz);

        });

        return myDropzones;

    }

    var financialChart = function(){
        if(document.querySelector("#financialChart")) {
            var options = {
                series: [{
                    name: 'Paid Invoices',
                    data: [20, 45, 28, 80, 60, 78, 25]
                }, {
                    name: 'Pending Invoices',
                    data: [30, 27, 52, 30, 65, 50, 67]
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar:{
                        show:false
                    },
                },
                colors:["#35c556","#f34040"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width:2,
                    curve: "straight"
                },
                legend:{
                    show:true,
                    position:'bottom',
                    horizontalAlign:'center',
                    fontSize:'14px',
                    fontFamily:'Inter',
                    labels:{
                        colors:'var(--bs-heading-color)'
                    },
                    markers:{
                        width:14,
                        height:14,
                        radius:6
                    },
                    itemMargin:{
                        horizontal:15,
                        vertical:5
                    }
                },
                grid:{
                    show:true,
                    strokeDashArray: 6,
                    borderColor: 'var(--bs-border-color)',
                },
                yaxis: {
                    labels:{
                        style:{
                            colors:'var(--bs-heading-color)',
                            fontSize:'13px',
                            fontFamily:'Inter',
                            fontWeight:400
                        },
                        formatter:function(val){
                            return val + "";
                        }
                    }
                },
                xaxis: {
                    categories: ["Jan","Mar","May","Jul","Sep","Nov","Dec"],
                    labels:{
                            style: {
                            colors: 'var(--bs-heading-color)',
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                            
                        },
                    },
                    axisTicks : {
                        show : false
                    },
                    axisBorder : {
                        show : false
                    },
                },
                fill:{
                    type:'gradient',
                    gradient: {
                        colorStops:[ 
                            [
                              {
                                offset: 0,
                                color: '#35c556',
                                opacity: .2
                              },
                              {
                                offset: 50,
                                color: '#35c556',
                                opacity: 0
                              },
                              {
                                offset: 100,
                                color: '#35c556',
                                opacity: 0
                              }
                            ],
                            [
                              {
                                offset: 0,
                                color: '#f34040',
                                opacity: .2
                              },
                              {
                                offset: 50,
                                color: '#f34040',
                                opacity: 0
                              },
                              {
                                offset: 100,
                                color: '#f34040',
                                opacity: 0
                              }
                            ]
                        ]
                    },
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        chart : {
                            height:200,
                        },
                        stroke :{
                            width : 3,
                            curve: "straight"
                        },
                        yaxis: {
                            labels:{
                                style: {
                                    fontSize: '11px',
                                },
                            },
                        },
                        xaxis: {
                            labels:{
                                style: {
                                    fontSize: '11px',
                                },
                            },
                        },
                    },
                }]
            };
      
            var chart = new ApexCharts(document.querySelector("#financialChart"), options);
            chart.render();

            $(".solar-financeNav .nav-link").on('click', function() {
                var seriesType = $(this).attr('data-series');
                var ajax_url = $("#financialChart").data('url');
                $.ajax({
                    url: ajax_url,
                    type: 'GET',
                    data: { seriesType: seriesType },
                    success: function(response) {
                        chart.updateOptions({
                            xaxis: { categories: response.categories }
                        });

                        chart.updateSeries([
                            { name: "Paid Invoices", data: response.paid },
                            { name: "Pending Invoices", data: response.pending }
                        ]);
                    }
                });
            });

            $('.solar-financeNav .nav-link').trigger('click');
        }
        
    }

    var handleAjaxModalForm = function () {
        if (jQuery('.AjaxModalForm').length > 0) {

            $(document)
                .off('submit','.AjaxModalForm')
                .on('submit','.AjaxModalForm',function(e){
                e.preventDefault();

                var form = $(this);
                var ajaxContainer = $(this).data('ajax-container');
                $('.error-text').text('');
                var formData = new FormData(this); 

                form.find('.formLoading').removeClass('d-none');

                $.ajax({
                    url: form.attr('action'), 
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                       
                        /* Needed ['status' => true / 'redirect' => url / 'reload' => true / 'close_modal' => true / 'message' => '' /  'html'  => html] in controller response*/
                        if (response.status) {

                            toastr.options = {
                                "closeButton": true,
                                "positionClass": "toast-top-left",
                                "progressBar": true,
                                "timeOut": "2000"
                            };

                            if (response.close_modal) {
                                const activeModal = document.querySelector('.modal.show');

                                if (activeModal) {
                                    const modalInstance = bootstrap.Modal.getInstance(activeModal);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    }
                                }
                                form.find('.formLoading').addClass('d-none');
                            }
                            if (response.close_offcanvas) {
                                const activeOffcanvas = document.querySelector('.offcanvas.show');

                                if (activeOffcanvas) {
                                    const offcanvasInstance = bootstrap.Offcanvas.getInstance(activeOffcanvas);
                                    if (offcanvasInstance) {
                                        offcanvasInstance.hide();
                                    }
                                }

                                // Refresh parent modal if reload_modal_url is provided
                                if (response.reload_modal_url) {
                                    $.get(response.reload_modal_url, function(data) {
                                        $('#AjaxModalBoxMd').find('.modal-content').html(data);
                                    });
                                }

                                form.find('.formLoading').addClass('d-none');
                            }
                            if (response.message) {
                                toastr.success(response.message);
                            }
                            if (response.redirect) {
                                setTimeout(function () {
                                    window.location.href = response.redirect;  // redirect to another page
                                }, 2000);
                            }
                            if (response.reload) {
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }

                            if(response.html){
                                if(ajaxContainer){
                                    $(ajaxContainer).html(response.html);
                                    if(ajaxContainer === "#DocumentWizard"){
                                        handleProjectDropzone();
                                        togglePassbook();
                                        $('#govtSubsidy').change(togglePassbook);
                                    }
                                }
                            }

                            return;
                        }
                        toastr.error('Something went wrong. Please try again.');

                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if(response.responseJSON.message){
                            toastr.error(response.responseJSON.message);
                        }
                        form.find('.formLoading').addClass('d-none');
                        if (errors) {
                            $.each(errors, function(key, value) {
                                form.find('.' + key + '_error').text(value); 
                            });
                        }
                    }
                });
            });
        }
    }

    var handleTransactionPayment = function () {

        $(document).on('change',"#TransactionInvoiceSelect", function() {
            var DueAmount = $(this).find(':selected').data('due_amount');
            $('#TransactionAmount').val('').attr('max',DueAmount);

            if (DueAmount < 1) {
                $('#TransactionAmount').prop('disabled', true);
            }else{
                $('#TransactionAmount').prop('disabled', false);
            }
        });

        $(document).on('change click','#TransactionTypeSelectBox, .contact-dropdown .on-dropdown-item',function(e){
            
            let invoice_ajax_url = $('#TransactionTypeSelectBox').data('invoice-url');
            let project_ajax_url = $('#TransactionTypeSelectBox').data('project-url');
            let sender_contact_id = $('#SenderPartyId').val();
            let reciever_contact_id = $('#RecieverPartyId').val();
            
            if ($('#TransactionTypeSelectBox').val() == 'invoice-payment') {
                $('#TransactionInvoiceContainer').show();
                $('#TransactionProjectContainer').hide();
            }else if($('#TransactionTypeSelectBox').val() == 'project-expenses'){
                $('#TransactionProjectContainer').show();
                $('#TransactionInvoiceContainer').hide();
            }else{
                $('#TransactionInvoiceContainer').hide();
                $('#TransactionProjectContainer').hide();
            }
            $('#TransactionAmount').prop('disabled', false).removeAttr('max');

            if (sender_contact_id && $('#TransactionTypeSelectBox').val() == 'invoice-payment') {

                $.ajax({
                    url: invoice_ajax_url, 
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'get',
                    data: {contact_id:sender_contact_id},
                    success: function (response) {
                        $('#TransactionInvoiceSelect').html(response);
                        $('#TransactionInvoiceSelect').selectpicker('refresh');

                    }
                });
            }
            if (reciever_contact_id && $('#TransactionTypeSelectBox').val() == 'project-expenses') {

                $.ajax({
                    url: project_ajax_url, 
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'get',
                    data: {contact_id:reciever_contact_id},
                    success: function (response) {
                        $('#TransactionProjectSelect').html(response);
                        $('#TransactionProjectSelect').selectpicker('refresh');

                    }
                });
            }

        });
        
    }

    var handleMaterialPrices = function () {
        $(document).on('input', '#WeightPerPiece', function(e) {

            var GiPricePerKg = $('#GiPricePerKg').val(); 
            var WeightPerPiece = $(this).val(); 
            $('#MaterialSellingPrice').val(WeightPerPiece*GiPricePerKg);
            $('#MaterialPurchasePrice').val(WeightPerPiece*GiPricePerKg);

            
        });
        /*$(document).on('input', '#MaterialPurchasePrice, #MaterialGST', function(e) {

            var thisVal = $('#MaterialPurchasePrice').val(); 
            var MaterialGST = $('#MaterialGST').val(); 
            $('#MaterialSellingPrice').val(thisVal);
            var CalculatedPrice = Number(thisVal) + Number(thisVal * (MaterialGST/100));
            $('#MaterialCalculatedPrice').val(CalculatedPrice);

        });*/
        $(document)
            .off('change', '#MaterialCategorySelect')
            .on('change', '#MaterialCategorySelect',function(e){

            var thisVal = $(this).val(); 
            var ajax_url = $(this).data('url'); 
            var thisText = $(this).find('option:selected').text();
            var unit = $(this).find('option:selected').data('unit');
            var gst = $(this).find('option:selected').data('gst');

            if ($('#MaterialUnitSelect').length > 0 && typeof unit !== 'undefined' && unit) {
                $('#MaterialUnitSelect').val(unit);
            }
            if ($('#MaterialGST').length > 0 && typeof gst !== 'undefined' && gst) {
                $('#MaterialGST').val(parseFloat(gst));
            }

            if (thisText == 'Structure') {
                $('#WeightPerPieceBox').show(); 
            }else if (thisText == 'Panel') {
                $('#PanelWattageBox').show(); 
                $('#WeightPerPieceBox').hide(); 
            }else{
                $('#WeightPerPieceBox').hide(); 
                $('#PanelWattageBox').hide(); 
                $('#MaterialPurchasePrice').prop('readonly', false);

            }

        });
    }

    var handleDateRangePicker = function () {
        if ($('.DateRangePicker').length > 0 ) {
            $('.DateRangePicker').daterangepicker({
                opens: 'left',
                locale: {
                        format: 'DD-MM-YYYY'
                    }
              });
        }
    }

    var handleMaxNumberOnInput = function () {
        $(document).on('input', '.checkMaxNumber', function() {
            let max = parseFloat($(this).attr('max'));
            let value = parseFloat($(this).val());
            if (value > max) {
                $(this).val(max);
            }
        });
    }

    var handleProjectPhasesForm = function () {
        $(document).on('submit', '#ProjectPhasesForm', function(e) {
            e.preventDefault();

            var form = $(this);
            $('.error-text').text('');

            form.find('.formLoading').removeClass('d-none');

            $.ajax({
                url: form.attr('action'), 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    form.find('.formLoading').addClass('d-none');

                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-left",
                        "progressBar": true,
                        "timeOut": "2000"
                    };
                    toastr.success(response.message);
                },
                error: function(response) {
                    form.find('.formLoading').addClass('d-none');
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(form).find('.' + key + '_error').text(value);
                    });
                }
            });
        });
    }

    var handleVerifyUserDirect = function () {

        // Handle individual field verify button click inside modal
        $(document).off('click', '.verifyFieldBtn').on('click', '.verifyFieldBtn', function () {
            var btn = $(this);
            var url = btn.data('url');
            var field = btn.data('field');

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Verifying...');

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { field: field },
                success: function (response) {
                    if (response.status) {
                        // Button turns green immediately
                        btn.removeClass('btn-outline-primary')
                           .addClass('bg-success-subtle border-success text-success')
                           .html('<span class="verified-text">' + field.charAt(0).toUpperCase() + field.slice(1) + ' Verified <i class="fas fa-check-circle ms-1"></i></span>');

                        // Toast
                        toastr.options = {
                            "closeButton": true,
                            "positionClass": "toast-top-left",
                            "progressBar": true,
                            "timeOut": "2000"
                        };
                        toastr.success(response.message);
                    }
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('<span class="verify-text">Verify ' + field.charAt(0).toUpperCase() + field.slice(1) + '</span>');
                    toastr.error(xhr.responseJSON.message || 'Something went wrong.');
                }
            });
        });
    };

    var handleWorkInProgressBtn = function () {

        $(document).on('click', '.work-in-progress', function(e) {
            e.preventDefault();
            e.stopPropagation();
            Swal.fire({
                title: 'Work in Progress',
                text: 'This feature is under development.',
                icon: 'info',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return false;
        });

    };

    /* Function ============ */
    return {
        init:function(){
            // handleModalCloseOffcanvas(); // not in used : but dont remove
            handleZIndexModalAndOffcanvas(); 
            handleImgOnChange(); 
            handleImgZoom(); 
            handleShowPass();
            handleDropdownSubmenu();
            handleTblOptions();
            handleLeadStageDropdownItem();
            handleBulkDelete();
            handleLeadChangeStatus();
            handleSetQuotationTitle();
            handleQuotation();
            handleCardProjectCardShowHide();
            handleProjectWizard();
            handleProjectDropzone();
            financialChart();
            handleAjaxModalForm();
            handleTransactionPayment();
            handleMaterialPrices();
            handleDateRangePicker();
            handleProjectPhasesForm();
            handleVerifyUserDirect();
            handleMaxNumberOnInput();
            handleWorkInProgressBtn();
        },
        
        ajaxLoad:function(){
            handleSetQuotationTitle();
            handleAjaxModalForm();
            handleMaterialPrices();
            handleDateRangePicker();
            handleProjectPhasesForm();
            handleVerifyUserDirect();
            handleMaxNumberOnInput();
            handleWorkInProgressBtn();
        },
        
        resize:function(){

        },
    }

}

jQuery(document).ready(function() {
    SolarMitra().init();
});

$(document).ajaxComplete(function (event, xhr, settings) {
    SolarMitra().ajaxLoad(); 
});