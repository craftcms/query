import QueryUtility from './QueryUtility.vue';

window.Cp.booting((cp) => {
  cp.$components.register('QueryUtility', QueryUtility);
});
