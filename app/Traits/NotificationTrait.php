<?php

namespace App\Traits;

trait NotificationTrait
{
    protected function setSuccessNotification($message)
    {
        session()->flash('success', $message);
    }

    protected function setErrorNotification($message)
    {
        session()->flash('error', $message);
    }

    protected function setWarningNotification($message)
    {
        session()->flash('warning', $message);
    }

    protected function setInfoNotification($message)
    {
        session()->flash('info', $message);
    }

    protected function redirectWithSuccess($message)
    {
        return redirect()->back()->with('success', $message);
    }

    protected function redirectWithError($message)
    {
        return redirect()->back()->with('error', $message);
    }

    protected function redirectWithWarning($message)
    {
        return redirect()->back()->with('warning', $message);
    }

    protected function redirectWithInfo($message)
    {
        return redirect()->back()->with('info', $message);
    }

    protected function redirectToWithSuccess($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('success', $message);
    }

    protected function redirectToWithError($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('error', $message);
    }

    protected function redirectToWithWarning($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('warning', $message);
    }

    protected function redirectToWithInfo($route, $message, $parameters = [])
    {
        return redirect()->route($route, $parameters)->with('info', $message);
    }
}
