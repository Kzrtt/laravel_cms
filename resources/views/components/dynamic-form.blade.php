<div>
    @foreach($formConfig as $group => $lines)
        <div>
            <p class="text-black/75 ml-3 font-semibold text-xl p-0 mb-5">{{ $group }}</p>

            @foreach($lines as $line => $fields)
                <div class="flex flex-row space-x-4 mx-3">
                    @foreach($fields as $key => $data)
                        @php
                            // Se estiver em modo de edição e o campo não deve ser editável, define como disabled
                            $disabled = $isEdit && !$data['edit'];
                            $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';
                        @endphp

                        <div x-data class="{{ $data['sizing'] }}">
                            <label for="{{ $data['identifier'] }}" class="block mb-2 text-sm font-medium text-gray-700"> 
                                {{ $data['label'] }} @isset($data['required']) <span class="text-red-500">*</span> @endisset
                            </label>

                            @if ($data['type'] == "select" || $data['type'] == "relation")
                                <select 
                                    wire:model.lazy="formData.{{ $data['identifier'] }}"

                                    @isset($data['updateRemoteField'])
                                        @if (@$data['updateRemoteField']['customRemote'])
                                            wire:change="{{ $data['updateRemoteField']['customRemote'] }}()"
                                        @else
                                            wire:change="updateRemoteField('{{ $data['identifier'] }}', @js($data['updateRemoteField']) )"
                                        @endif
                                    @endisset

                                    placeholder="Selecione o {{ $data['label'] }}"
                                    id="{{ $data['identifier'] }}"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30 {{ $disabledClasses }}"
                                    @if($disabled) disabled @endif
                                >
                                    <option value="">Selecionar...</option>
                                    @foreach ($selectsPopulate[$data['identifier']] as $key => $value)
                                        <option value="{{ $key }}" {{ $formData[$data['identifier']] == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            @else
                                <!-- Input -->
                                <input
                                    wire:model.lazy.debounce.500ms="formData.{{ $data['identifier'] }}"
                                    type="text"
                                    id="{{ $data['identifier'] }}"
                                    name="{{ $data['identifier'] }}"
                                    placeholder="{{ $data['placeholder'] }}"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30 {{ $disabledClasses }}"
                                    @if($disabled) disabled @endif
                                    @if (@$data['mask']) x-mask="{{ $data['mask'] }}" @endif
                                />
                            @endif

                            <!-- Texto de ajuda ou erro -->
                            @error("formData." . $data['identifier'])
                                <p class="mt-2 text-xs text-red-500 font-semibold">{{ $message }}</p>
                            @else
                                <p class="mt-2 text-xs text-secondary-500/60 font-semibold">{{ $data['helper'] }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="border-[0.3px] mx-3 my-4 border-primary-300"></div>
    @endforeach
</div>