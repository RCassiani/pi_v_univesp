<?php

if (!function_exists('btnForm')) {

    function btnForm($url, $isEdit = false)
    {
        return btnCancel($url, $isEdit) . btnSave();
    }
}

if (!function_exists('btnCancel')) {

    function btnCancel($url, $isEdit = false)
    {

        $sa_message = $isEdit ? trans('sys.alert.cancel.sa_message_edit') : trans('sys.alert.cancel.sa_message');
        return '<span href="' . $url . '"
                data-sa-type="question"
                data-sa-show-cancel="' . $isEdit . '"
                data-sa-title="' . trans('sys.alert.cancel.sa_title') . '"
                data-sa-message="' . $sa_message . '"
                data-sa-confirmbuttontext="' . trans('sys.alert.cancel.sa_confirmButtonText') . '"
                data-sa-cancelbuttontext="' . trans('sys.alert.cancel.sa_cancelButtonText') . '"
                data-sa-popuptitlecancel="' . trans('sys.alert.cancel.sa_popupTitleCancel') . '"
                class="btn btn-danger btn-cancel btn-md">
                <i class="fa fa fa-times"></i>&nbsp;&nbsp;' . trans('sys.btn.cancel') . '
                </span>';

    }
}

if (!function_exists('btnSave')) {

    function btnSave()
    {
        return '<button type="submit" class="btn btn-success btn-md pull-right">
                <i class="fa fa-save"></i>
                &nbsp;&nbsp;' . trans('sys.btn.save') . '
                </button>';
    }
}

if (!function_exists('btnDelete')) {

    function btnDelete($url, $permission)
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->hasPermissionTo($permission)) {
            return '<span href="' . $url . '"
                data-sa-title="' . trans('sys.alert.delete.sa_title') . '"
                data-sa-type="warning"
                data-sa-message="' . trans('sys.alert.delete.sa_message') . '"
                data-sa-confirmbuttontext="' . trans('sys.alert.delete.sa_confirmButtonText') . '"
                data-sa-cancelbuttontext="' . trans('sys.alert.delete.sa_cancelButtonText') . '"
                data-sa-popuptitlecancel="' . trans('sys.alert.delete.sa_popupTitleCancel') . '"
                data-original-title="' . trans('sys.btn.delete') . '"
                data-placement="top"
                class="btn btn-delete">
                <i class="material-icons md-12" id="grid-delete">delete</i>
                </span>';
        }
        return false;
    }
}

if (!function_exists('btnEdit')) {

    function btnEdit($url, $permission)
    {
        if (Auth::user()->isSuperAdmin() || Auth::user()->hasPermissionTo($permission))
            return '<a href="' . $url . '" class="btn btn-edit"><i class="material-icons md-12" id="grid-edit">edit</i></a>';
        return false;
    }
}

if (!function_exists('btnNew')) {

    function btnNew($url)
    {
        return '<a href="' . $url . '">
                <button type="button" name="create_record" id="create_record" class="btn btn-success" style="padding-left: 0.5rem; padding-right: 0.5rem">
                <i class="fa fa-plus"></i>
                &nbsp;' . trans('sys.btn.new') . '
                </button>
                </a>';
    }
}

