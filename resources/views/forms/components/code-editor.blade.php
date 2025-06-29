@php
    $statePath = $getStatePath();   // مسار الحالة داخل Livewire
    $lang      = $getLanguage();    // ace mode
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- محرّر Ace --}}
    <div
        x-data="codeEditor(
            @entangle('{{ $statePath }}').defer,
            '{{ $lang }}'
        )"
        class="relative"
    >
        <div x-ref="ace" class="h-64 w-full border rounded-md text-sm"></div>
    </div>

    {{-- تحميل Ace مرّة واحدة --}}
    @once
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ace.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ext-language_tools.min.js"></script>

        <script>
            function codeEditor (bind, mode) {
                return {
                    state: bind,
                    mode,
                    init () {
                        const editor = ace.edit(this.$refs.ace)

                        editor.setTheme('ace/theme/github')
                        editor.session.setMode(`ace/mode/${this.mode}`)
                        editor.session.setValue(this.state || '')
                        editor.setOptions({
                            wrap: true,
                            tabSize: 2,
                            useSoftTabs: true,
                        })

                        /* Ace ➜ Livewire */
                        editor.session.on('change', () => {
                            this.state = editor.getValue()
                        })

                        /* Livewire ➜ Ace */
                        this.$watch('state', value => {
                            if (value !== editor.getValue()) {
                                editor.session.setValue(value || '')
                            }
                        })
                    }
                }
            }
        </script>
    @endonce
</x-dynamic-component>
