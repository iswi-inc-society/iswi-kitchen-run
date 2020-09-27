<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render guest informations for email
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       Team      $team           Cooking Team
 * @var       int       $course         Course number
 * @var       string    $date           String of the Event Date
 * @var       string    $start_time     String of the time for the course
 * @var       string    $end_time       String of the end time for the course
 */

$course_name='';

switch($course) {
    case 0:
        $course_name = 'Appetizer';
        break;
    case 1:
        $course_name = 'Main Course';
        break;
    case 2:
        $course_name = 'Dessert';
        break;
}

?>

<table class="row">
	<tbody>
	<tr>

		<th class="small-12 large-12 columns first last">
			<table>
				<tr>
					<th>
                        <h5><?= $course_name ?>: <b><?= $start_time ?> to <?= $end_time ?></b> </h5>
                        <h6>Guest Team</h6>
						<p>The Cooking Team got your teams food preference and food request. Here are all the information you need:

                            <!--- CALLOUT -->
						<table class="callout large-12">
							<tr>
								<th class="callout-inner secondary large-12">

									<table class="desc">
										<tr>
											<td>Team:</td><td><?= $team->getName() ?></td>
										</tr>

										<tr>
											<td>Contact:</td><td><?= $team->getEmail() ?></td>
										</tr>

										<tr>
											<td>Address:</td><td><?= $team->getAddress() ?></td>
										</tr>

										<tr>
											<td>City:</td><td><?= $team->getCity() ?></td>
										</tr>

									</table>
								</th>
								<th class="expander"></th>
							</tr>
						</table>

						<p>Addentional description of their address: <?= $team->getFindPlace() ?></p>
					</th>
				</tr>
			</table>
		</th>
	</tr>
	</tbody>
</table>