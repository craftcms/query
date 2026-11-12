<script setup>
  import {computed, ref} from 'vue';
  import {getCpUrl, t} from '@craftcms/cp';

  const sql = ref('');
  const executing = ref(false);
  const response = ref(null);

  const rows = computed(() =>
    response.value?.success ? response.value.result : []
  );
  const columns = computed(() => Object.keys(rows.value[0] ?? {}));

  const summary = computed(() => {
    if (!response.value) {
      return '';
    }

    if (!response.value.success) {
      return t('The query failed.', {}, 'query');
    }

    switch (rows.value.length) {
      case 0:
        return t('No results', {}, 'query');
      case 1:
        return t('1 result', {}, 'query');
      default:
        return t(
          '{num} results',
          {num: response.value.formattedTotal},
          'query'
        );
    }
  });

  function execute() {
    if (executing.value) {
      return;
    }

    window.Cp.$router.post(
      getCpUrl('utilities/query'),
      {sql: sql.value},
      {
        preserveState: true,
        preserveScroll: true,
        onStart: () => (executing.value = true),
        onFinish: () => (executing.value = false),
        onFlash: (flash) => {
          if (flash.query) {
            response.value = flash.query;
          }
        },
        onError: (errors) => {
          response.value = {success: false, error: Object.values(errors)[0]};
        },
      }
    );
  }
</script>

<template>
  <div class="query-utility">
    <form @submit.prevent="execute">
      <craft-textarea
        :label="t('SQL', {}, 'query')"
        :help-text="t('Press Ctrl+Enter or ⌘+Enter to execute.', {}, 'query')"
        .value="sql"
        rows="6"
        monospace
        @keydown.enter.ctrl.prevent="execute"
        @keydown.enter.meta.prevent="execute"
      >
        <textarea
          slot="input"
          spellcheck="false"
          @input="sql = $event.target.value"
        ></textarea>
      </craft-textarea>

      <div class="query-actions">
        <craft-button type="submit" variant="primary" .loading="executing">
          {{ t('Execute', {}, 'query') }}
        </craft-button>
      </div>
    </form>

    <p role="status" class="query-summary">{{ summary }}</p>

    <craft-callout
      v-if="response && !response.success"
      variant="danger"
      class="query-error"
      ><span class="query-error-text">{{ response.error }}</span></craft-callout
    >

    <div
      v-if="rows.length"
      class="query-results"
      role="region"
      :aria-label="t('Results', {}, 'query')"
      tabindex="0"
    >
      <table>
        <thead>
          <tr>
            <th v-for="column in columns" :key="column" scope="col">
              {{ column }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="index">
            <td v-for="column in columns" :key="column">
              <span v-if="row[column] === null" class="query-null">NULL</span>
              <template v-else>{{ row[column] }}</template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
  .query-actions {
    margin-block-start: var(--c-spacing-lg);
  }

  .query-summary {
    margin-block: var(--c-spacing-lg) var(--c-spacing-md);
  }

  .query-summary:empty {
    margin: 0;
  }

  /* Keeps the database's line breaks and the caret under the error position.
     Set on the text, not the callout, so the callout's own markup isn't affected. */
  .query-error-text {
    font-family: var(--c-font-mono);
    white-space: pre-wrap;
  }

  .query-results {
    max-width: 100%;
    overflow-x: auto;
  }

  .query-results:focus-visible {
    outline: 2px solid currentColor;
    outline-offset: 2px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    padding: var(--c-spacing-md) var(--c-spacing-lg);
    border-block-end: 1px solid var(--c-color-border-quiet);
    text-align: start;
    vertical-align: top;
  }

  td {
    font-family: var(--c-font-mono);
    white-space: pre-wrap;
  }

  .query-null {
    font-style: italic;
    opacity: 0.7;
  }
</style>
