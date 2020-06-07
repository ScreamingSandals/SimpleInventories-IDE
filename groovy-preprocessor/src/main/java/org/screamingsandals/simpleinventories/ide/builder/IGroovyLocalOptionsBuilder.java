package org.screamingsandals.simpleinventories.ide.builder;

import groovy.lang.Closure;

import java.util.HashMap;
import java.util.Map;

import static org.screamingsandals.simpleinventories.ide.GroovyUtils.internalCallClosure;

public interface IGroovyLocalOptionsBuilder {
    public static final int ROWS = 4;
    public static final int ITEMS_ON_ROW = 9;
    public static final int RENDER_ACTUAL_ROWS = 6;
    public static final int RENDER_OFFSET = 9;
    public static final int RENDER_HEADER_START = 0;
    public static final int RENDER_FOOTER_START = 45;

    default void backItem(Closure<IGroovyStackBuilder> closure) {
        Map<String, Object> stack = new HashMap<>();
        internalCallClosure(closure, new GroovyLongStackBuilder(stack));
        backItem(stack);
    }
    default void pageBackItem(Closure<IGroovyStackBuilder> closure) {
        Map<String, Object> stack = new HashMap<>();
        internalCallClosure(closure, new GroovyLongStackBuilder(stack));
        pageBackItem(stack);
    }
    default void pageForwardItem(Closure<IGroovyStackBuilder> closure) {
        Map<String, Object> stack = new HashMap<>();
        internalCallClosure(closure, new GroovyLongStackBuilder(stack));
        pageForwardItem(stack);
    }
    default void cosmeticItem(Closure<IGroovyStackBuilder> closure) {
        Map<String, Object> stack = new HashMap<>();
        internalCallClosure(closure, new GroovyLongStackBuilder(stack));
        cosmeticItem(stack);
    }

    void backItem(Map<String, Object> stack);
    void pageBackItem(Map<String, Object> stack);
    void pageForwardItem(Map<String, Object> stack);
    void cosmeticItem(Map<String, Object> stack);

    void rows(int rows);
    void itemsOnRow(int itemsOnRow);
    void renderActualRows(int renderActualItems);
    void renderOffset(int renderOffset);
    void renderHeaderStart(int renderHeaderStart);
    void renderFooterStart(int renderFooterStart);

    void inventoryType(String inventoryType);
}
