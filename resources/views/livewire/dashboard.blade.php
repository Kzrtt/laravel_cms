<div class="flex flex-col justify-center items-center pt-10">
    @php
        //prettyPrint(session('usr_permissions'));
    @endphp

    <h1 class="mt-10">Dashboard, Usuário Autenticado => {{ auth()->user()->getPerson->pes_name }}</h1>

    <div class="w-100 mt-10 mb-10">
        <x-select label="Order Status" placeholder="Select one status"
            :options="[
                ['name' => 'Active', 'id' => 1, 'description' => 'The status is active'],
                ['name' => 'Pending', 'id' => 2, 'description' => 'The status is pending'],
                ['name' => 'Stuck', 'id' => 3, 'description' => 'The status is stuck'],
                ['name' => 'Done', 'id' => 4, 'description' => 'The status is done'],
            ]" option-label="name" option-value="id"
        />
    </div>

    <div class="mt-10 space-x-4">
        <x-custom-button 
            color="primary" 
            click="console.log('teste');" 
            clickType="alpine" 
            text="teste"
            icon="fad fa-yin-yang"
        />

        <x-custom-button 
            color="secondary" 
            click="console.log('teste');" 
            clickType="alpine" 
            text="teste"
        />

        <x-custom-button 
            color="warning" 
            click="console.log('teste');" 
            clickType="alpine" 
            text="teste"
        />
    </div>
</div>  
