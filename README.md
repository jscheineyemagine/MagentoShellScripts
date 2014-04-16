MagentoShellScripts
===================

Some general utility shell scripts that can come in handy for magento.



###Search The Compiled config.xml By XPath

Example Usage:

    shell $ php shell/SearchConfigXPaths.php --search "default/admin/startup/page,default/admin/security/password"

	/default/admin/startup/page : dashboard
	/default/admin/security/password_lifetime : 90
	/default/admin/security/password_is_forced : 1
	/stores/default/admin/startup/page : dashboard
	/stores/default/admin/security/password_lifetime : 90
	/stores/default/admin/security/password_is_forced : 1
	jschein@IMAC-001 $

	shell $
