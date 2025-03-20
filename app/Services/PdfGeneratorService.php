<?php

namespace App\Services;

use App\Models\Membership\Member;
use TCPDF;

class PdfGeneratorService {
    public function generateMembershipApplication(Member $member) {
        $html = view('pdf.membership-application', ['member' => $member])->render();
        $filename = __('members.apply.print.filename', ['tm' => date('YmdHis'), 'id' => $member->id]);

        $pdf = new TCPDF;
        $pdf->SetTitle(__('members.apply.print.title'));
        $pdf->SetSubject(__('members.apply.print.title'));
        $pdf->setMargins(24, 10, 10);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($filename, 'D');

        return redirect()->route('home'); // Optional, depending on desired behavior
    }
}
