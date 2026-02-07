<?php

use Livewire\Volt\Component;

new class extends Component {

    
}; ?>

<div
x-data="{
    notify: function(message) {
        this.$notify(message, {
            wrapperId: 'flashMessageWrapper',
            templateId: 'flashMessageTemplate',
            autoClose: 3000,
            autoRemove: 4000,
        })
    }
}"
    x-on:notification-created.dot.window="notify($event.detail.message)"
    @session('flash-message') x-init="notify('{{ $value }}')" @endsession
>

<style>
    @keyframes bounce {
  0% {
    transform: translateY(100%);
    opacity: 0;
  }
  40% {
    transform: translateY(-20%);
    opacity: 1;
  }
  60% {
    transform: translateY(10%);
  }
  80% {
    transform: translateY(-4%);
  }
  100% {
    transform: translateY(0);
  }
}
</style>

    <div
        id="flashMessageWrapper"
        class="fixed left-1/2 transform -translate-x-1/2 top-6 flex flex-col z-50 w-fit gap-4"
    >
    </div>

    <template id="flashMessageTemplate">
        <div>
            <div
                role="alert"
                class="max-w-80 relative flex items-center gap-4 rounded-2xl bg-white/15 px-5 py-3 font-medium text-base text-gray-800 leading-5 border border-zinc-200 backdrop-blur-xl backdrop-saturate-150 shadow-2xl opacity-100 overflow-hidden drop-shadow-xl animate-[bounce_0.6s_cubic-bezier(0.25,1.5,0.5,1)_both] duration-500 ease-out"
            >
                {notificationText}
            </div>
        </div>

    </template>
</div>