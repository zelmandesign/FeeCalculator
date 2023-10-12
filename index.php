<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

require 'src/Model/LoanProposal.php';
require 'src/FeeCalculator.php';
//require 'src/RangeBasedFeeCalculator.php';
require 'src/RangeTermFeeCalculator.php';

//use PragmaGoTech\Interview\RangeBasedFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\RangeTermFeeCalculator;

// Example usage
// $calculator = new RangeBasedFeeCalculator();

// echo "<table>
//         <tr>
//             <th>Loan Amount</th>
//             <th>Term</th>
//             <th>Fee</th>
//         </tr>";

// $loanProposal1 = new LoanProposal(12, 19100); // 12-month term
// $fee1 = $calculator->calculate($loanProposal1);
// echo "<tr>
//         <td>{$loanProposal1->amount()} PLN</td>
//         <td>{$loanProposal1->term()} months</td>
//         <td>{$fee1} PLN</td>
//       </tr>";

// $loanProposal2 = new LoanProposal(12, 1000); // 12-month term
// $fee2 = $calculator->calculate($loanProposal2);
// echo "<tr>
//         <td>{$loanProposal2->amount()} PLN</td>
//         <td>{$loanProposal2->term()} months</td>
//         <td>{$fee2} PLN</td>
//       </tr>";

// $loanProposal3 = new LoanProposal(24, 3650); // 24-month term
// $fee3 = $calculator->calculate($loanProposal3);
// echo "<tr>
//         <td>{$loanProposal3->amount()} PLN</td>
//         <td>{$loanProposal3->term()} months</td>
//         <td>{$fee3} PLN</td>
//       </tr>";

// $loanProposal4 = new LoanProposal(24, 4327); // 24-month term
// $fee4 = $calculator->calculate($loanProposal4);
// echo "<tr>
//         <td>{$loanProposal4->amount()} PLN</td>
//         <td>{$loanProposal4->term()} months</td>
//         <td>{$fee4} PLN</td>
//       </tr>";

// echo "</table>";

$calculator = new RangeTermFeeCalculator();

// Create an array of LoanProposals with different terms and amounts
$loanProposals = [
    new LoanProposal(12, 19100),
    new LoanProposal(12, 1000),
    new LoanProposal(24, 3650),
    new LoanProposal(24, 4327),
    new LoanProposal(24, 1000),
    new LoanProposal(12, 1000),
    new LoanProposal(24, 11500),
    new LoanProposal(12, 19250),
];

echo "<table>
    <tr>
        <th>Loan Term</th>
        <th>Loan Amount</th>
        <th>Fee</th>
    </tr>";

foreach ($loanProposals as $loanProposal) {
    $term = $loanProposal->term();
    $amount = $loanProposal->amount();
    $fee = $calculator->calculate($loanProposal);

    echo "<tr>
        <td>{$term} months</td>
        <td>{$amount} PLN</td>
        <td>{$fee} PLN</td>
    </tr>";
}

echo "</table>";
