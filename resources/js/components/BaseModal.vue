<script setup>
defineEmits(["close-modal"]);
defineProps({
  modalActive: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
    <Teleport to="body">
      <Transition name="modal-outer">
        <div
          v-show="modalActive"
          class="modal-box"
        >
          <Transition name="modal-item">
            <div
              v-if="modalActive"
              class="modal-item"
            >
              <slot />
             <div class="btn-box">
                <button
                class="modal-btn"
                @click="$emit('close-modal')"
              >
                Close
              </button>
             </div>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </template>
  
  <style scoped>
	.btn-box{
		text-align: center;
	}
  .modal-box{
    display: flex; 
    position: absolute; 
    top: 0; 
    left: 0; 
    padding-left: 1rem;
    padding-right: 1rem; 
    justify-content: center; 
    width: 100%; 
    height: 100%; 
    background: rgba(0, 0, 0, 0.4);
    overflow: scroll;
  }

  .modal-item{
    padding: 1rem; 
    margin-top: 2rem; 
    align-self: flex-start; 
    max-width: 1080px;
    min-width: 612px; 
    background-color: #0b4f94; 
    color: white;
  }

  .modal-btn{
    padding: 0.5rem 1.5rem 0.5rem 1.5rem;
    margin-top: 2rem;
    background-color: #ebc474; 
    color: white; 
    border: none;
    border-radius: 15px;
  }


  .modal-outer-enter-active,
  .modal-outer-leave-active {
    transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
  }
  
  .modal-outer-enter-from,
  .modal-outer-leave-to {
    opacity: 0;
  }
  
  .modal-inner-enter-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
  }
  
  .modal-inner-leave-active {
    transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
  }
  
  .modal-inner-enter-from {
    opacity: 0;
    transform: scale(0.8);
  }
  
  .modal-inner-leave-to {
    transform: scale(0.8);
  }
  </style>