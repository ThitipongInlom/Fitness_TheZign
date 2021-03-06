<div class="col-md-6">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title" style="margin-bottom: 0.0rem">ลูกค้าที่ใช้งานตอนนี้</h3>
			<div class="card-tools">
				<i class="fas fa-2x fa-globe-americas" data-toggle="tooltip" data-placement="left" title="ลูกค้าที่ใช้งานตอนนี้"></i>
			</div>
		</div>
		<div class="card-body" align="center" style="padding: 0.1rem;">
			<div class="overflow-auto" style="height: 50vh;">
				<div data-simplebar data-simplebar-auto-hide="false">
					<div id="TableOnline"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="card card-danger">
		<div class="card-header">
			<h3 class="card-title" style="margin-bottom: 0.0rem">ลูกค้าที่ใช้งานเสร็จสิ้นวันนี้</h3>
			<div class="card-tools">
				<i class="fas fa-2x fa-globe-africa" data-toggle="tooltip" data-placement="left" title="ลูกค้าที่ใช้งานวันนี้"></i>
			</div>
		</div>
		<div class="card-body" align="center" style="padding: 0.1rem;">
			<div class="overflow-auto" style="height: 50vh;">
				<div data-simplebar data-simplebar-auto-hide="false">
					<div id="TableToday"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="Show_view_Data" tabindex="-1" role="dialog" aria-labelledby="Show_view_Data_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary" style="padding: 0.7rem;">
				<h5 class="modal-title" id="Show_view_Data_title">ตัวอย่างสิ่งของที่ใช้งาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="padding: 0.5rem;">
				<div id="Show_view_Data_Table"></div>
				<hr>
				<div align="center">
					<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
				</div>
			</div>
		</div>
	</div>
</div>
