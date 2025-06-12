<?php

$users = App\Models\UserModel::whereIn('exam_status', ['success', 'passed', 'fail'])->get();

foreach($users as $user) {
    if($user->role == 'admin') {
        echo "Skipping admin: " . $user->identity_number . "\n";
        continue;
    }
    
    echo "Deleting user: " . $user->identity_number . "\n";
    
    App\Models\ExamResultModel::where('user_id', $user->user_id)->delete();
    
    if($user->role == 'student') {
        App\Models\StudentModel::where('user_id', $user->user_id)->delete();
    }
    
    $user->delete();
}

?>