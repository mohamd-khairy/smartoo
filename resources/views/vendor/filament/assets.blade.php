@if (isset($data))
    <script>
        window.filamentData = @js($data)
    </script>
@endif

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>

<script>
    function toggleDirection() {
        axios.get('/change-language').then(response => {
            location.reload();
        });
        /* const currentDirection = document.documentElement.getAttribute('dir') || 'ltr';
        const newDirection = currentDirection === 'ltr' ? 'rtl' : 'ltr';
        document.documentElement.setAttribute('dir', newDirection);

        // Optionally, save the preference to localStorage
        localStorage.setItem('pageDirection', newDirection); */
    }

    // On page load, apply the saved direction
    document.addEventListener('DOMContentLoaded', () => {
        const savedDirection = localStorage.getItem('pageDirection');
        if (savedDirection) {
            document.documentElement.setAttribute('dir', savedDirection);
        }
    });

</script>

<script>
    async function toggleDirection() {
        const currentLanguage = "{{ app()->getLocale() }}";
        const newLanguage = currentLanguage === 'en' ? 'ar' : 'en';

        try {
            const response = await fetch('{{ route('api.change-language') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ locale: newLanguage }),
            });

            /* location.reload(); */
            if (response.ok) {
                const data = await response.json();

                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
