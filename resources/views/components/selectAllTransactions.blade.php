<section x-data="checkAll" class="flex items-center gap-2">
    <flux:checkbox @change="handleChecked" />
    <button type="button" x-cloak x-show="$wire.selectedTransactions.length !== $wire.transactions.length" @click="selectAll">all {{ $this->numTransactions }}</button>
</section>


@script
<script>
    Alpine.data('checkAll', ()=>{
        return {
            handleChecked(e){
                e.target.checked ? this.selectAllOnPage() : this.deselectAll()
            },

            selectAllOnPage(){
                this.$wire.transactionsOnPage.forEach(id => {
                    if ( this.$wire.selectedTransactions.includes(id)) return
                    this.$wire.selectedTransactions.push(id)
                })
            },

            selectAll(){
                this.$wire.selectedTransactions = this.$wire.allTransactions
            },

            deselectAll(){
                this.$wire.selectedTransactions = []
            }
        }
    })
</script>
@endscript
