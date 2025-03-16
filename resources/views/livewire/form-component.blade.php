<div class="flex justify-center w-full">  
    <div class="w-4/5 flex flex-col justify-center p-5">
        <p wire:loading>Carregando...</p>
        <form wire:loading.remove wire:submit.prevent="submitForm">

            <!-- Alerta para Preenchimento dos Campos -->
            <div class="flex flex-row items-center bg-white w-full container px-5 py-4 mt-2 rounded-lg">
                <i class="fad fa-exclamation-triangle ml-2 text-warning-600 text-2xl"></i>
                <div class="ml-3">
                    <p class="text-gray-500 ml-3 text-lg p-0 m-0">Atente para os campos em <span class="text-red-400">*negrito</span>, eles são obrigatórios</p>
                </div>
            </div> 

            <!-- Card do Formulário -->
            <div class="w-full mt-6 bg-white p-5 rounded-lg">
                <div class="flex flex-row items-center justify-between">
                    <p class="text-black/75 ml-3 font-semibold text-xl p-0 m-0">Formuário para criação de {{$params['_title']}}</p>

                    <button 
                        type="button"
                        @click="window.history.back()"
                        class="relative p-2 mr-3 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:cursor-pointer hover:shadow-sm">
                        <i class="fad fa-undo text-xl p-1"></i>
                    </button>
                </div>

                <div class="border-[0.3px] mx-3 my-6 border-primary-300"></div>

                <x-dynamic-form :formConfig="$formConfig" :selectsPopulate="$selectsPopulate" :formData="$formData" />
            </div>

            <div class="flex flex-row justify-end w-full mt-6 bg-white p-5 rounded-lg">
                <div class="space-x-2">
                    <button
                        type="button"
                        @click="$dispatch('back')"
                        class="bg-primary-200/55 text-primary-600 p-2 rounded-lg hover:bg-primary-300 hover:text-white transition hover:cursor-pointer">
                        <i class="fad fa-times-circle p-1"></i>
                        &nbsp;<span class="font-semibold">Cancelar</span>&nbsp;
                    </button>

                    <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                        <i class="fad fa-check-circle p-1"></i>
                        &nbsp;<span class="font-semibold">Salvar</span>&nbsp;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>