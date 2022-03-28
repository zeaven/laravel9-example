@component('./vendor/mail/html/layout')
    {{--     Header --}}
    @slot('header')
        @component('./vendor/mail/html/header', ['url' => config('app.url')])
            zeaven.cc
        @endcomponent
    @endslot

    {{--     Body --}}
    {!! $content !!}

    {{--     Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('./vendor/mail/html/subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{--     Footer --}}
    @slot('footer')
        @component('./vendor/mail/html/footer')
            © {{ date('Y') }} zeaven.cc @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
