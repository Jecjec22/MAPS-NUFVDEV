</div>
                                    <div class="full progress_bar_inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="full">
                                                    <div class="padding_infor_info">
                                                        <div class="alert alert-primary" role="alert">
                                                            <form method="post" onsubmit="return validateDates();">
                                                                <!-- Rest of the code... -->
                                                                <div class="field">
                                                                    <div class="field">
                                                                        <label class="label_field">Assigned to</label>
                                                                        <select type="text" id="emplist" name="emplist" class="form-control" required='true'>
                                                                            <?php
                                                                            $sql2 = "SELECT * FROM tblemployee WHERE ID NOT IN (
                                                                                SELECT AssignTaskto FROM tbltask WHERE (StartDate <= :endDate) AND (TaskEnddate >= :startDate)
                                                                            )";
                                                                            $query2 = $dbh->prepare($sql2);
                                                                            $query2->bindParam(':startDate', $startDate, PDO::PARAM_STR);
                                                                            $query2->bindParam(':endDate', $endDate, PDO::PARAM_STR);
                                                                            $query2->execute();
                                                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                                            foreach ($result2 as $row3) {
                                                                                ?>
                                                                                <option value="<?php echo htmlentities($row3->ID); ?>"><?php echo htmlentities($row3->EmpName); ?>(<?php echo htmlentities($row3->EmpId); ?>)</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>