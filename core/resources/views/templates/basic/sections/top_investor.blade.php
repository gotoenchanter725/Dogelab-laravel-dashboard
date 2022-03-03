@php
    $content        = getContent('top_investor.content',true);
    $top_investors  = App\Models\Deposit::where('status', 1)->groupBy('account_id')->selectRaw("id, account_id, wallet,SUM(amount) as amount")->limit(6)->get();
@endphp

<section class="investor-section pt-120 pb-120">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__cate">
                @lang($content->data_values->title)
            </span>
            <h3 class="section__title">@lang($content->data_values->subtitle)</h3>
            <p>@lang(@$content->data_values->description)</p>
        </div>
        <div class="row g-4">
            @foreach ($top_investors as $item)

                <div class="col-xl-4 col-md-6">
                    <div class="investor__item">

                        <div class="investor__thumb">
                            <img src="{{ getImage('assets/images/frontend/top_investor/'.@$content->data_values->image, '600x600') }}" alt="investor">
                        </div>

                        <div class="investor__content">
                            <h6 class="investor__title">{{ shortDescription($item->account->wallet, 16) }}</h6>
                            <span class="total__invest"><span class="text--success">{{ getAmount($item->amount, 8) }}</span> @lang($general->cur_text)</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
