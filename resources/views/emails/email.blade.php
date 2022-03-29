@component('./vendor/mail/html/layout')
    {{--     Header --}}
    @slot('header')
        @component('./vendor/mail/html/header', ['url' => config('app.url')])
            {{ config('app.domain') }}
        @endcomponent
    @endslot

    {{--     Body --}}
    ### {{ $name }}(先生/女士)，您好！

    {{ $content }}

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
            © {{ date('Y') }} {{ config('app.domain') }} @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
