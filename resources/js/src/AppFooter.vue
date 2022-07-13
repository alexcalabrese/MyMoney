<template>
	<div class="layout-footer">
		<img alt="Logo" src="/images/logo.svg" height="20" class="mr-2" />
		MyMoney
	</div>
</template>

<script>

	export default {
		name: "AppFooter",
		computed: {
			darkTheme() {
				return this.$appState.theme.startsWith('saga');
			}
		},
	}
</script>

<style scoped>

</style>