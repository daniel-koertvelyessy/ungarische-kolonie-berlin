<section x-data="checkAll" class="flex items-center gap-2">
    <flux:checkbox @change="handleChecked" />
    <button type="button" x-cloak x-show="$wire.selectedApplicants.length !== $wire.applicants.length" @click="selectAll">all {{ $this->numApplicants }}</button>
</section>


@script
<script>
    Alpine.data('checkAll', ()=>{
        return {
            handleChecked(e){
                e.target.checked ? this.selectAllOnPage() : this.deselectAll()
            },

            selectAllOnPage(){
                this.$wire.applicantsOnPage.forEach(id => {
                    if ( this.$wire.selectedApplicants.includes(id)) return
                    this.$wire.selectedApplicants.push(id)
                })
            },

            selectAll(){
                this.$wire.selectedApplicants = this.$wire.allApplicants
            },

            deselectAll(){
                this.$wire.selectedApplicants = []
            }
        }
    })
</script>
@endscript
