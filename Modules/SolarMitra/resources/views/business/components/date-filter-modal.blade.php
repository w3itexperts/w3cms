<button class="btn btn-outline-primary" data-bs-target="#DateFilter" data-bs-toggle="modal">{{ __('solarmitra::solarmitra.date_filter') }}</button>
<div class="modal fade" id="DateFilter" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DateFilter" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="get" action="">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('solarmitra::solarmitra.date_filter') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-3" type="text" name="datetimes">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="lastWeek">
                        <label class="form-check-label" for="lastWeek">{{ __('solarmitra::solarmitra.last_week') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="thisWeek">
                        <label class="form-check-label" for="thisWeek">{{ __('solarmitra::solarmitra.this_week') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="today">
                        <label class="form-check-label" for="today">{{ __('solarmitra::solarmitra.today') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="thisMonth">
                        <label class="form-check-label" for="thisMonth">{{ __('solarmitra::solarmitra.this_month') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="lastMonth">
                        <label class="form-check-label" for="lastMonth">{{ __('solarmitra::solarmitra.last_month') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="fy2425">
                        <label class="form-check-label" for="fy2425">{{ __('solarmitra::solarmitra.fy_2024_2025') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="fy2324">
                        <label class="form-check-label" for="fy2324">{{ __('solarmitra::solarmitra.fy_2023_2024') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="fy2223">
                        <label class="form-check-label" for="fy2223">{{ __('solarmitra::solarmitra.fy_2022_2023') }}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="alL">
                        <label class="form-check-label" for="alL">{{ __('solarmitra::solarmitra.all') }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('solarmitra::solarmitra.apply') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>